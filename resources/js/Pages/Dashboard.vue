<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import ExpensesPieChart from '@/Components/ExpensesPieChart.vue';
import IncomeExpenseLine from '@/Components/IncomeExpenseLine.vue';

const props = defineProps({
    accounts: Array,
    totalBalance: Number,
    monthlyIncome: Number,
    monthlyExpenses: Number,
    recentTransactions: Array,
    expensesByCategory: Array,
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('es-PE', {
        style: 'currency',
        currency: 'PEN'
    }).format(amount);
};

const monthlyBalance = props.monthlyIncome - props.monthlyExpenses;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Financiero</h2>
                <div class="flex gap-3">
                    <Link :href="route('accounts.create')"
                          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        + Nueva Cuenta
                    </Link>
                    <Link :href="route('transactions.create')"
                          class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        + Nueva Transacción
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Tarjetas de resumen -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-gray-600 mb-2">Balance Total</div>
                        <div class="text-3xl font-bold text-gray-900">
                            {{ formatCurrency(totalBalance) }}
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-gray-600 mb-2">Ingresos del Mes</div>
                        <div class="text-3xl font-bold text-green-600">
                            {{ formatCurrency(monthlyIncome) }}
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-gray-600 mb-2">Gastos del Mes</div>
                        <div class="text-3xl font-bold text-red-600">
                            {{ formatCurrency(monthlyExpenses) }}
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-gray-600 mb-2">Balance del Mes</div>
                        <div class="text-3xl font-bold" :class="monthlyBalance >= 0 ? 'text-green-600' : 'text-red-600'">
                            {{ formatCurrency(monthlyBalance) }}
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Gráfico de Gastos por Categoría -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Gastos por Categoría</h3>
                        <div class="h-80">
                            <ExpensesPieChart :data="expensesByCategory" />
                        </div>
                    </div>

                    <!-- Gráfico de Ingresos vs Gastos -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Tendencia: Ingresos vs Gastos</h3>
                        <div class="h-80">
                            <IncomeExpenseLine
                                :monthly-income="monthlyIncome"
                                :monthly-expenses="monthlyExpenses"
                            />
                        </div>
                    </div>
                </div>

                <!-- Cuentas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Mis Cuentas</h3>
                        <Link :href="route('accounts.index')" class="text-blue-600 hover:text-blue-800 text-sm">
                            Ver todas →
                        </Link>
                    </div>
                    <div v-if="accounts.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div v-for="account in accounts" :key="account.id"
                             class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium">{{ account.name }}</span>
                                <span class="text-sm text-gray-500">{{ account.type }}</span>
                            </div>
                            <div class="text-2xl font-bold" :style="{ color: account.color }">
                                {{ formatCurrency(account.balance) }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ account.currency }}
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-8 text-gray-500">
                        <p class="mb-4">No tienes cuentas registradas.</p>
                        <Link :href="route('accounts.create')"
                              class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                            Crear mi primera cuenta
                        </Link>
                    </div>
                </div>

                <!-- Transacciones Recientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Transacciones Recientes</h3>
                        <Link :href="route('transactions.index')" class="text-blue-600 hover:text-blue-800 text-sm">
                            Ver todas →
                        </Link>
                    </div>
                    <div v-if="recentTransactions.length > 0" class="space-y-3">
                        <div v-for="transaction in recentTransactions" :key="transaction.id"
                             class="flex items-center justify-between py-3 border-b last:border-b-0">
                            <div class="flex items-center space-x-3">
                                <div class="text-2xl">{{ transaction.category.icon }}</div>
                                <div>
                                    <div class="font-medium">{{ transaction.category.name }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ transaction.account.name }} • {{ new Date(transaction.transaction_date).toLocaleDateString('es-PE') }}
                                    </div>
                                    <div v-if="transaction.description" class="text-xs text-gray-400">
                                        {{ transaction.description }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-lg font-semibold"
                                 :class="transaction.type === 'income' ? 'text-green-600' : 'text-red-600'">
                                {{ transaction.type === 'income' ? '+' : '-' }}{{ formatCurrency(transaction.amount) }}
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-8 text-gray-500">
                        <p class="mb-4">No hay transacciones registradas.</p>
                        <Link :href="route('transactions.create')"
                              class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition">
                            Agregar mi primera transacción
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

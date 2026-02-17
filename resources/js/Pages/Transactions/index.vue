<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    transactions: Object, // Paginación de Laravel
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('es-PE', {
        style: 'currency',
        currency: 'PEN'
    }).format(amount);
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('es-PE', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const deleteTransaction = (id) => {
    if (confirm('¿Estás seguro de eliminar esta transacción? Esta acción no se puede deshacer.')) {
        router.delete(route('transactions.destroy', id));
    }
};
</script>

<template>
    <Head title="Mis Transacciones" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Todas las Transacciones</h2>
                <Link :href="route('transactions.create')"
                      class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    + Nueva Transacción
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Tabla -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Categoría
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cuenta
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Descripción
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Monto
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="transaction in transactions.data" :key="transaction.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ formatDate(transaction.transaction_date) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="flex items-center gap-2">
                                            <span class="text-xl">{{ transaction.category.icon }}</span>
                                            <span>{{ transaction.category.name }}</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ transaction.account.name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ transaction.description || '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full"
                                            :class="transaction.type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                        >
                                            {{ transaction.type === 'income' ? 'Ingreso' : 'Gasto' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold"
                                        :class="transaction.type === 'income' ? 'text-green-600' : 'text-red-600'"
                                    >
                                        {{ transaction.type === 'income' ? '+' : '-' }}{{ formatCurrency(transaction.amount) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <Link
                                                :href="route('transactions.edit', transaction.id)"
                                                class="text-blue-600 hover:text-blue-900"
                                            >
                                                Editar
                                            </Link>
                                            <button
                                                @click="deleteTransaction(transaction.id)"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div v-if="transactions.data.length > 0" class="px-6 py-4 border-t flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Mostrando {{ transactions.from }} a {{ transactions.to }} de {{ transactions.total }} transacciones
                        </div>
                        <div class="flex gap-2">
                            <Link
                                v-for="link in transactions.links"
                                :key="link.label"
                                :href="link.url"
                                class="px-3 py-2 text-sm rounded"
                                :class="link.active
                                    ? 'bg-blue-600 text-white'
                                    : link.url
                                        ? 'bg-white border hover:bg-gray-50'
                                        : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                            >
                                {{ link.label }}
                            </Link>
                        </div>
                    </div>

                    <!-- Estado vacío -->
                    <div v-if="transactions.data.length === 0" class="px-6 py-12 text-center">
                        <div class="text-gray-400 text-5xl mb-4">📝</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay transacciones</h3>
                        <p class="text-gray-600 mb-6">Comienza agregando tu primera transacción</p>
                        <Link :href="route('transactions.create')"
                              class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition">
                            + Nueva Transacción
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

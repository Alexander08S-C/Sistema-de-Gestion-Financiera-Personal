<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    accounts: Array,
    categories: Array,
});

const form = useForm({
    account_id: props.accounts[0]?.id || '',
    category_id: '',
    type: 'expense',
    amount: 0,
    description: '',
    transaction_date: new Date().toISOString().split('T')[0],
});

const submit = () => {
    form.post(route('transactions.store'));
};

const expenseCategories = props.categories.filter(c => c.type === 'expense');
const incomeCategories = props.categories.filter(c => c.type === 'income');

const filteredCategories = computed(() => {
    return form.type === 'expense' ? expenseCategories : incomeCategories;
});
</script>

<template>
    <Head title="Nueva Transacción" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Agregar Nueva Transacción</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo de Transacción *
                            </label>
                            <div class="flex gap-4">
                                <label class="flex items-center cursor-pointer">
                                    <input
                                        v-model="form.type"
                                        type="radio"
                                        value="expense"
                                        class="mr-2"
                                    />
                                    <span class="text-red-600 font-medium">💸 Gasto</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input
                                        v-model="form.type"
                                        type="radio"
                                        value="income"
                                        class="mr-2"
                                    />
                                    <span class="text-green-600 font-medium">💰 Ingreso</span>
                                </label>
                            </div>
                            <div v-if="form.errors.type" class="text-red-600 text-sm mt-1">
                                {{ form.errors.type }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Cuenta *
                            </label>
                            <select
                                v-model="form.account_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option value="">Selecciona una cuenta</option>
                                <option v-for="account in accounts" :key="account.id" :value="account.id">
                                    {{ account.name }} ({{ account.currency }})
                                </option>
                            </select>
                            <div v-if="form.errors.account_id" class="text-red-600 text-sm mt-1">
                                {{ form.errors.account_id }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Categoría *
                            </label>
                            <select
                                v-model="form.category_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option value="">Selecciona una categoría</option>
                                <option v-for="category in filteredCategories" :key="category.id" :value="category.id">
                                    {{ category.icon }} {{ category.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.category_id" class="text-red-600 text-sm mt-1">
                                {{ form.errors.category_id }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Monto *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-gray-500">S/</span>
                                <input
                                    v-model.number="form.amount"
                                    type="number"
                                    step="0.01"
                                    class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="0.00"
                                    required
                                />
                            </div>
                            <div v-if="form.errors.amount" class="text-red-600 text-sm mt-1">
                                {{ form.errors.amount }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha *
                            </label>
                            <input
                                v-model="form.transaction_date"
                                type="date"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            />
                            <div v-if="form.errors.transaction_date" class="text-red-600 text-sm mt-1">
                                {{ form.errors.transaction_date }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción (opcional)
                            </label>
                            <textarea
                                v-model="form.description"
                                rows="3"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Ej: Compras en supermercado, Pago de servicios, etc."
                            ></textarea>
                            <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">
                                {{ form.errors.description }}
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition disabled:opacity-50"
                            >
                                {{ form.processing ? 'Guardando...' : 'Agregar Transacción' }}
                            </button>
                            <Link
                                :href="route('dashboard')"
                                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium text-center transition inline-block"
                            >
                                Cancelar
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

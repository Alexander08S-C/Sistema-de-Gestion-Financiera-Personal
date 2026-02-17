<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    type: 'savings',
    balance: 0,
    currency: 'PEN',
    color: '#10B981',
});

const submit = () => {
    form.post(route('accounts.store'));
};

const accountTypes = [
    { value: 'checking', label: 'Cuenta Corriente' },
    { value: 'savings', label: 'Cuenta de Ahorros' },
    { value: 'credit_card', label: 'Tarjeta de Crédito' },
    { value: 'cash', label: 'Efectivo' },
];

const colors = [
    '#10B981', '#3B82F6', '#EF4444', '#F59E0B',
    '#8B5CF6', '#EC4899', '#6366F1', '#14B8A6'
];
</script>

<template>
    <Head title="Nueva Cuenta" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Nueva Cuenta</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre de la Cuenta *
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Ej: Cuenta BCP, Tarjeta Visa"
                                required
                            />
                            <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo de Cuenta *
                            </label>
                            <select
                                v-model="form.type"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option v-for="type in accountTypes" :key="type.value" :value="type.value">
                                    {{ type.label }}
                                </option>
                            </select>
                            <div v-if="form.errors.type" class="text-red-600 text-sm mt-1">
                                {{ form.errors.type }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Balance Inicial *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-gray-500">S/</span>
                                <input
                                    v-model.number="form.balance"
                                    type="number"
                                    step="0.01"
                                    class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="0.00"
                                    required
                                />
                            </div>
                            <div v-if="form.errors.balance" class="text-red-600 text-sm mt-1">
                                {{ form.errors.balance }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Moneda *
                            </label>
                            <select
                                v-model="form.currency"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option value="PEN">PEN - Soles</option>
                                <option value="USD">USD - Dólares</option>
                                <option value="EUR">EUR - Euros</option>
                            </select>
                            <div v-if="form.errors.currency" class="text-red-600 text-sm mt-1">
                                {{ form.errors.currency }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Color *
                            </label>
                            <div class="flex gap-3">
                                <button
                                    v-for="color in colors"
                                    :key="color"
                                    type="button"
                                    @click="form.color = color"
                                    class="w-10 h-10 rounded-full transition-transform hover:scale-110"
                                    :class="form.color === color ? 'ring-4 ring-offset-2 ring-gray-400' : ''"
                                    :style="{ backgroundColor: color }"
                                ></button>
                            </div>
                            <div v-if="form.errors.color" class="text-red-600 text-sm mt-1">
                                {{ form.errors.color }}
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition disabled:opacity-50"
                            >
                                {{ form.processing ? 'Guardando...' : 'Crear Cuenta' }}
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

<script setup>
import { computed } from 'vue';
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    Filler
} from 'chart.js';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    Filler
);

const props = defineProps({
    monthlyIncome: Number,
    monthlyExpenses: Number,
});

const chartData = computed(() => {
    return {
        labels: ['Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero'],
        datasets: [
            {
                label: 'Ingresos',
                data: [3000, 3200, 3500, 3400, 3600, props.monthlyIncome],
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true,
            },
            {
                label: 'Gastos',
                data: [2500, 2800, 2600, 2900, 2700, props.monthlyExpenses],
                borderColor: '#EF4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true,
            }
        ]
    };
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top',
        },
        tooltip: {
            callbacks: {
                label: function(context) {
                    return `${context.dataset.label}: S/ ${context.parsed.y.toFixed(2)}`;
                }
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                callback: function(value) {
                    return 'S/ ' + value;
                }
            }
        }
    }
};
</script>

<template>
    <div class="w-full h-full">
        <Line :data="chartData" :options="chartOptions" />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Pie } from 'vue-chartjs';
import {
    Chart as ChartJS,
    ArcElement,
    Tooltip,
    Legend
} from 'chart.js';

ChartJS.register(ArcElement, Tooltip, Legend);

const props = defineProps({
    data: Array,
});

const chartData = computed(() => {
    if (!props.data || props.data.length === 0) {
        return {
            labels: ['Sin datos'],
            datasets: [{
                data: [1],
                backgroundColor: ['#E5E7EB'],
            }]
        };
    }

    return {
        labels: props.data.map(item => item.category),
        datasets: [{
            data: props.data.map(item => item.total),
            backgroundColor: props.data.map(item => item.color),
            borderWidth: 2,
            borderColor: '#fff',
        }]
    };
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom',
            labels: {
                padding: 15,
                font: {
                    size: 12
                }
            }
        },
        tooltip: {
            callbacks: {
                label: function(context) {
                    const label = context.label || '';
                    const value = context.parsed || 0;
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = ((value / total) * 100).toFixed(1);
                    return `${label}: S/ ${value.toFixed(2)} (${percentage}%)`;
                }
            }
        }
    }
};
</script>

<template>
    <div class="w-full h-full">
        <Pie :data="chartData" :options="chartOptions" />
    </div>
</template>

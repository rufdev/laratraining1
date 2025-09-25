<script setup lang="ts">
import BarChart from '@/components/chartcomponents/BarChart.vue';
import PieChart from '@/components/chartcomponents/PieChart.vue';
import DoughnutChart from '@/components/chartcomponents/DoughnutChart.vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];




const totals = ref<any>({
    total_assets: 0,
    total_categories: 0,
    total_manufacturers: 0,
    total_locations: 0,
    total_users: 0,
});
const charts = ref({} as any);
const loading = ref(true);

const fetchStats = async () => {
    try {
        const response = await axios.get('/dashboard/stats');
        totals.value = response.data.totals;
        charts.value = response.data.charts;
    } catch (error) {
        console.error('Error fetching dashboard stats:', error);
    }
};

const generateRandomColor = () => {
    const randomColor = `#${Math.floor(Math.random() * 16777215).toString(16)}`;
    return randomColor.padEnd(7, '0'); // Ensure the color is always 6 characters long
};

let chartData: any;
let chartOptions: any;

let piechartData: any;
let piechartOptions: any;

let doughnutData: any;
let doughnutOptions: any;

let chart2Data: any;
let chart2Options: any;

const rendercharts = () => {
     // Asset by Status Bar Chart
     chartData = {
        labels: charts.value.assets_by_status ? charts.value.assets_by_status.map((item: any) => item.status) : [],
        datasets: [
            {
                label: 'Assets by Status',
                backgroundColor: charts.value.assets_by_status ? charts.value.assets_by_status.map(() => generateRandomColor()) : [],
                data: charts.value.assets_by_status ? charts.value.assets_by_status.map((item: any) => item.total) : [],
            },
        ],
    };
    chartOptions = {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            title: {
                display: true,
                text: 'Total Assets by Status',
            },
            datalabels: {
                display: true,
                color: '#000000', // Label text color
                font: {
                    size: 14, // Label font size
                    weight: 'bold',
                },
                formatter: (value: any) => {
                    // const label = context.chart.data.labels[context.dataIndex];
                    return `${value}`; // Format: "Label: Value"
                },
            },
        },
    };

     //Pie Chart Asset by Category
     piechartData = {
        labels: charts.value.assets_by_category ? charts.value.assets_by_category.map((item: any) => item.category.name) : [],
        datasets: [
            {
                label: 'Assets by Category',
                backgroundColor: charts.value.assets_by_category ? charts.value.assets_by_category.map(() => generateRandomColor()) : [],
                data: charts.value.assets_by_category ? charts.value.assets_by_category.map((item: any) => item.total) : [],
            },
        ],
    };

    piechartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                
                position: 'left',
            },
            title: {
                display: true,
                text: 'Total Assets by Category',
            },
            datalabels: {
                display: true,
                color: '#000000', // Label text color
            },
        },
    };
};

onMounted(async () => {
    loading.value = true;
    await fetchStats();
    rendercharts();
    loading.value = false;
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <div
                    class="rounded-xl  bg-green-600 border bg-card text-card-foreground shadow"
                >
                    <div
                        class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2"
                    >
                        <h3 class="text-sm font-medium tracking-tight">
                            Total Assets
                        </h3>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="text-2xl font-bold">{{ totals.total_assets }}</div>
                    </div>
                </div>
                <div
                    class="rounded-xl border bg-card text-card-foreground shadow"
                >
                    <div
                        class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2"
                    >
                        <h3 class="text-sm font-medium tracking-tight">
                            Total Users
                        </h3>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="text-2xl font-bold">{{ totals.total_users }}</div>
                    </div>
                </div>
                <div
                    class="rounded-xl border bg-card text-card-foreground shadow"
                >
                    <div
                        class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2"
                    >
                        <h3 class="text-sm font-medium tracking-tight">
                            Total Categories
                        </h3>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="text-2xl font-bold">{{ totals.total_categories }}</div>
                    </div>
                </div>
                <div
                    class="rounded-xl border bg-card text-card-foreground shadow"
                >
                    <div
                        class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2"
                    >
                        <h3 class="text-sm font-medium tracking-tight">
                            Total Manufacturers
                        </h3>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="text-2xl font-bold">{{ totals.total_manufacturers }}</div>
                    </div>
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div v-if="loading" class="flex h-full items-center justify-center">
                        <div class="spinner-border inline-block h-8 w-8 animate-spin rounded-full border-4" role="status"></div>
                    </div>
                    <div v-else>
                        <BarChart :chart-data="chartData" :chart-options="chartOptions" />
                    </div>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div v-if="loading" class="flex h-full items-center justify-center">
                        <div class="spinner-border inline-block h-8 w-8 animate-spin rounded-full border-4" role="status"></div>
                    </div>
                    <div v-else>
                        <PieChart :chart-data="piechartData" :chart-options="piechartOptions" />
                    </div>
                </div>
            </div>
                
            </div>
        </div>
    </AppLayout>
</template>

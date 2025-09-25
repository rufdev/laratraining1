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

const fetchStats = async () => {
    try {
        const response = await axios.get('/dashboard/stats');
        totals.value = response.data.totals;
        
    } catch (error) {
        console.error('Error fetching dashboard stats:', error);
    }
};

onMounted(async () => {
    await fetchStats();
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
                    class="rounded-xl border bg-card text-card-foreground shadow"
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
                <Card class="w-[350px]">
                    <CardHeader>
                        <CardTitle>Create project</CardTitle>
                        <CardDescription
                            >Deploy your new project in
                            one-click.</CardDescription
                        >
                    </CardHeader>
                    <CardContent>
                        <form>
                            <div class="grid w-full items-center gap-4">
                                <div class="flex flex-col space-y-1.5">
                                    <Label for="name">Name</Label>
                                    <Input
                                        id="name"
                                        placeholder="Name of your project"
                                    />
                                </div>
                                <div class="flex flex-col space-y-1.5">
                                    <Label for="framework">Framework</Label>
                                    <Select>
                                        <SelectTrigger id="framework">
                                            <SelectValue placeholder="Select" />
                                        </SelectTrigger>
                                        <SelectContent position="popper">
                                            <SelectItem value="nuxt">
                                                Nuxt
                                            </SelectItem>
                                            <SelectItem value="next">
                                                Next.js
                                            </SelectItem>
                                            <SelectItem value="sveltekit">
                                                SvelteKit
                                            </SelectItem>
                                            <SelectItem value="astro">
                                                Astro
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                            </div>
                        </form>
                    </CardContent>
                    <CardFooter class="flex justify-between px-6 pb-6">
                        <Button variant="outline"> Cancel </Button>
                        <Button>Deploy</Button>
                    </CardFooter>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

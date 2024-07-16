<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
	<Head title="Dashboard" />

	<AuthenticatedLayout title="Dashboard" dashboard>
		<div class="h-full"></div>
	</AuthenticatedLayout>
</template>

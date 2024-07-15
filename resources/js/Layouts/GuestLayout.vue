<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
</script>

<template>
	<div
		class="flex min-h-screen flex-col items-center justify-center bg-surface-100 dark:bg-surface-950">
		<ApplicationLogo class="mb-4 size-20 fill-transparent stroke-primary" />

		<slot />
	</div>
</template>

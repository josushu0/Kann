<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { User } from '@/types'
import { Head } from '@inertiajs/vue3'
import UserForm from './Partials/UserForm.vue'
</script>

<template>
	<AuthenticatedLayout title="Create User">
		<Head title="Create User" />
		<div class="flex h-full items-center justify-center py-6">
			<Card class="w-full sm:w-fit">
				<template #content>
					<UserForm />
				</template>
			</Card>
		</div>
	</AuthenticatedLayout>
</template>

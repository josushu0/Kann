<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DeleteUserForm from './Partials/DeleteUserForm.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
import { Head } from '@inertiajs/vue3'

defineProps<{
	status?: string
}>()
</script>

<template>
	<Head title="Profile" />

	<AuthenticatedLayout title="Profile">
		<div class="container mx-auto space-y-4 py-6">
			<UpdateProfileInformationForm :status="status" />

			<UpdatePasswordForm />

			<DeleteUserForm />
		</div>
	</AuthenticatedLayout>
</template>

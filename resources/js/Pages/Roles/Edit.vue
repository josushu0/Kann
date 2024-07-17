<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Role } from '@/types'
import { Head } from '@inertiajs/vue3'
import RoleForm from './Partials/RoleForm.vue'

defineProps<{
	role: Role
	rolePermissions: Role[]
	permissions: Role[]
}>()
</script>

<template>
	<AuthenticatedLayout title="Edit User">
		<Head title="Edit User" />
		<div class="flex h-full items-center justify-center py-6">
			<Card class="w-full max-w-5xl">
				<template #content>
					<RoleForm
						:role="role"
						:role-permissions="rolePermissions"
						:permissions="permissions"
						edit />
				</template>
			</Card>
		</div>
	</AuthenticatedLayout>
</template>

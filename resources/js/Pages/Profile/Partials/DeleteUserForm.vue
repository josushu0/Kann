<script setup lang="ts">
import ConfirmPasswordDialog from '@/Components/ConfirmPasswordDialog.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const confirmingUserDeletion = ref(false)
const passwordInput = ref<HTMLInputElement | null>(null)
const content =
	'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.'

const form = useForm({
	password: '',
})

const deleteUser = (password: string) => {
	form.password = password
	form.delete(route('profile.destroy'), {
		preserveScroll: true,
		onError: () => passwordInput.value?.focus(),
		onFinish: () => {
			form.reset()
		},
	})
}
</script>

<template>
	<Card>
		<template #title>
			<h2>Delete Account</h2>
		</template>
		<template #subtitle>
			Once your account is deleted, all of its resources and data will be
			permanently deleted.
		</template>
		<template #content>
			<ConfirmPasswordDialog
				triggerLabel="Delete Account"
				actionLabel="Delete"
				severity="danger"
				header="Are you sure you want to delete your account?"
				:content="content"
				:error="form.errors.password"
				:processing="form.processing"
				@confirm="deleteUser" />
		</template>
	</Card>
</template>

<script setup>
import { nextTick, reactive, ref } from 'vue'
import InputError from './InputError.vue'
import {
	Dialog,
	DialogClose,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
	DialogTrigger,
} from '@/Components/shadcn/ui/dialog/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const emit = defineEmits(['confirmed'])

const props = defineProps({
	title: {
		type: String,
		default: 'Confirm Password',
	},
	content: {
		type: String,
		default: 'For your security, please confirm your password to continue.',
	},
	button: {
		type: String,
		default: 'Confirm',
	},
	alwaysAsk: {
		type: Boolean,
		default: false,
	},
})

const form = reactive({
	password: '',
	error: '',
	processing: false,
})

const openModal = ref(false)

const startConfirmingPassword = () => {
	if (!props.alwaysAsk) {
		axios.get(route('password.confirmation')).then((response) => {
			if (response.data.confirmed) {
				emit('confirmed')
			}
		})
	}
}

const confirmPassword = () => {
	form.processing = true

	axios
		.post(route('password.confirm'), {
			password: form.password,
		})
		.then(() => {
			form.processing = false
			nextTick().then(() => emit('confirmed', form.password))
		})
		.catch((error) => {
			form.processing = false
			form.error = error.response.data.errors.password[0]
		})

	openModal.value = false
}
</script>

<template>
	<Dialog v-model:open="openModal">
		<DialogTrigger as-child @click="startConfirmingPassword">
			<slot />
		</DialogTrigger>
		<DialogContent>
			<DialogHeader>
				<DialogTitle>{{ title }}</DialogTitle>
				<DialogDescription>{{ content }}</DialogDescription>
			</DialogHeader>
			<div>
				<Label for="password" class="sr-only">Password</Label>
				<Input
					type="password"
					placeholder="Password"
					v-model="form.password"
					@keyup.enter="confirmPassword" />
				<InputError :message="form.error" class="mt-2" />
			</div>
			<div class="flex justify-end gap-2">
				<DialogClose as-child>
					<Button variant="outline">Cancel</Button>
				</DialogClose>
				<Button :disabled="form.processing" @click="confirmPassword">
					{{ button }}
				</Button>
			</div>
		</DialogContent>
	</Dialog>
</template>

<script setup lang="ts">
import InputError from '@/Components/InputError.vue'
import { User } from '@/types'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps<{
	user?: User
	edit?: boolean
}>()

const created_at = props.user
	? new Date(props.user.created_at).toLocaleString()
	: ''
const updated_at = props.user
	? new Date(props.user.updated_at).toLocaleString()
	: ''

const form = useForm({
	name: props.user ? props.user.name : '',
	email: props.user ? props.user.email : '',
	title: props.user ? props.user.title : '',
	department: props.user ? props.user.department : '',
	phone: props.user ? props.user.phone : '',
	password: '',
})

const handleSubmit = () => {
	if (props.edit && props.user) {
		form.put(route('users.update', props.user.id))
	} else {
		form.post(route('users.store'))
	}
}
</script>

<template>
	<div v-if="user" class="mb-4 flex flex-col items-center gap-2">
		<label for="avatar" class="sr-only">Avatar</label>
		<a href="https://gravatar.com/" target="_blank">
			<Avatar id="avatar" :image="user.avatar" shape="circle" size="xlarge" />
		</a>
	</div>
	<h2 v-if="!user" class="mb-6 text-center text-2xl font-bold">New User</h2>
	<form @submit.prevent="handleSubmit" class="grid gap-4 sm:grid-cols-2">
		<div class="space-y-4">
			<div class="flex flex-col">
				<label for="name">Name</label>
				<InputText
					id="name"
					name="name"
					type="text"
					v-model="form.name"
					:invalid="form.errors.name ? true : false"
					required />
				<InputError :message="form.errors.name" />
			</div>
			<div class="flex flex-col">
				<label for="email">Email</label>
				<InputText
					id="email"
					name="email"
					type="email"
					v-model="form.email"
					:invalid="form.errors.email ? true : false"
					required />
				<InputError :message="form.errors.email" />
			</div>
			<div class="flex flex-col">
				<label for="title">Title</label>
				<InputText
					id="title"
					name="title"
					type="text"
					v-model="form.title"
					:invalid="form.errors.title ? true : false" />
				<InputError :message="form.errors.title" />
			</div>
			<div class="flex flex-col">
				<label for="department">Department</label>
				<InputText
					id="department"
					name="department"
					type="text"
					v-model="form.department"
					:invalid="form.errors.department ? true : false" />
				<InputError :message="form.errors.department" />
			</div>
		</div>
		<div class="space-y-4">
			<div class="flex flex-col">
				<label for="phone">Phone number</label>
				<InputMask
					id="phone"
					name="phone"
					v-model="form.phone"
					mask="999-999-99-99" />
				<InputError :message="form.errors.phone" />
			</div>
			<div class="flex flex-col">
				<label for="created_at">Created at</label>
				<InputText
					id="created_at"
					name="created_at"
					type="text"
					v-model="created_at"
					disabled />
			</div>
			<div class="flex flex-col">
				<label for="updated_at">Updated at</label>
				<InputText
					id="updated_at"
					name="updated_at"
					type="text"
					v-model="updated_at"
					disabled />
			</div>
			<div v-if="!edit" class="flex flex-col">
				<label for="password">Password</label>
				<Password
					id="password"
					name="password"
					v-model="form.password"
					toggle-mask
					input-class="w-full" />
				<InputError :message="form.errors.password" />
			</div>
		</div>
		<div class="flex justify-end gap-2 sm:col-span-2">
			<Link :href="route('users.index')">
				<Button severity="secondary" type="button" label="Cancel" />
			</Link>
			<Button label="Save" type="submit" />
		</div>
	</form>
</template>

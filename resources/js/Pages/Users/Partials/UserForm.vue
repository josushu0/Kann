<script setup>
import { Button } from '@/Components/shadcn/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/shadcn/ui/card';
import { Input } from '@/Components/shadcn/ui/input';
import { Label } from '@/Components/shadcn/ui/label';
import { Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import { Checkbox } from '@/Components/shadcn/ui/checkbox';

const props = defineProps({
	user: {
		type: Object,
		required: false
	}
})

const form = useForm({
	name: props.user ? props.user.name : '',
	email: props.user ? props.user.email : '',
	department: props.user ? props.user.department : '',
	phone: props.user ? props.user.phone : '',
	location: props.user ? props.user.location : '',
	password: '',
	is_admin: props.user ? (props.user.is_admin === 1 ? true : false) : false
})

const handleSubmit = () => {
	if (props.user) {
		form.put(route('users.update', props.user))
	} else {
		console.log(form)
		form.post(route('users.store'))
	}
}
</script>

<template>
	<Card class="mx-auto w-full max-w-3xl border-0 shadow-none md:border md:shadow-sm">
		<CardHeader>
			<CardTitle v-if="!user">Create a new user</CardTitle>
			<CardTitle v-else>Edit user</CardTitle>
		</CardHeader>
		<CardContent>
			<form @submit.prevent="handleSubmit" class="w-full space-y-4">
				<div>
					<Label for="name">Name</Label>
					<Input type="text" id="name" name="name" placeholder="Name" v-model="form.name" />
					<InputError :message="form.errors.name" class="mt-2" />
				</div>
				<div>
					<Label for="email">Email</Label>
					<Input type="email" id="email" name="email" placeholder="Email" v-model="form.email" />
					<InputError :message="form.errors.email" class="mt-2" />
				</div>
				<div>
					<Label for="department">Department</Label>
					<Input type="text" id="department" name="department" placeholder="Department" v-model="form.department" />
					<InputError :message="form.errors.department" class="mt-2" />
				</div>
				<div>
					<Label for="phone">Phone</Label>
					<Input type="text" id="phone" name="phone" placeholder="Phone" v-model="form.phone" />
					<InputError :message="form.errors.phone" class="mt-2" />
				</div>
				<div>
					<Label for="location">Location</Label>
					<Input type="text" id="location" name="location" placeholder="Location" v-model="form.location" />
					<InputError :message="form.errors.location" class="mt-2" />
				</div>
				<div v-if="!user">
					<Label for="password">Password</Label>
					<Input type="password" id="password" name="password" placeholder="Password" v-model="form.password" />
					<InputError :message="form.errors.password" class="mt-2" />
				</div>
				<div>
					<div class="flex items-center gap-2">
						<Checkbox id="is_admin" :checked="form.is_admin" @update:checked="(value) => form.is_admin = value" />
						<Label for="is_admin">Admin</Label>
					</div>
					<InputError :message="form.errors.is_admin" class="mt-2" />
				</div>
				<div class="flex justify-end gap-2">
					<Button variant="outline" type="button" as-child>
						<Link :href="route('users.index')">Cancel</Link>
					</Button>
					<Button v-if="!user" type="submit" :disabled="form.processing">Create</Button>
					<Button v-else type="submit" :disabled="form.processing">Save</Button>
				</div>
			</form>
		</CardContent>
	</Card>
</template>

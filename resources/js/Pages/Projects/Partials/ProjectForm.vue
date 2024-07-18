<script setup lang="ts">
import InputError from '@/Components/InputError.vue'
import { Project } from '@/types'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps<{
	project?: Project
}>()

const form = useForm({
	name: props.project ? props.project.name : '',
	description: props.project ? props.project.description : '',
	start_date: props.project ? props.project.start_date : '',
	due_date: props.project ? props.project.due_date : '',
})

const handleSubmit = () => {
	if (props.project) {
		form.put(route('projects.update', props.project.id))
	} else {
		form.post(route('projects.store'))
	}
}
</script>

<template>
	<h1 class="mb-4 text-center text-2xl font-bold">
		{{ project ? 'Edit Project' : 'Create Project' }}
	</h1>
	<form @submit.prevent="handleSubmit" class="space-y-4">
		<div class="flex flex-col">
			<label for="name">Name</label>
			<InputText
				id="name"
				name="name"
				type="text"
				v-model="form.name"
				:invalid="form.errors.name ? true : false" />
			<InputError :message="form.errors.name" />
		</div>
		<div class="flex flex-col">
			<label for="description">Description</label>
			<Textarea
				id="description"
				name="description"
				v-model="form.description"
				auto-resize />
		</div>
		<div class="flex gap-2">
			<div class="flex w-full flex-col">
				<label for="start">Start date</label>
				<DatePicker
					id="start"
					name="start"
					v-model="form.start_date"
					:invalid="form.errors.start_date ? true : false"
					show-icon />
				<InputError :message="form.errors.start_date" />
			</div>
			<div class="flex w-full flex-col">
				<label for="end">Due date</label>
				<DatePicker
					id="end"
					name="end"
					v-model="form.due_date"
					:invalid="form.errors.due_date ? true : false"
					show-icon />
				<InputError :message="form.errors.due_date" />
			</div>
		</div>
		<div class="flex justify-end gap-4">
			<Link
				:href="
					project ? route('projects.show', project.id) : route('projects.index')
				">
				<Button label="Cancel" type="button" severity="secondary" />
			</Link>
			<Button label="Save" type="submit" />
		</div>
	</form>
</template>

<script setup lang="ts">
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps<{
	project: number
}>()

const form = useForm({
	name: '',
	project: props.project,
})

const createTaskList = () => {
	form.post(route('lists.store'), {
		preserveState: false,
		preserveScroll: true,
	})
}
</script>

<template>
	<Card class="h-fit select-none">
		<template #content>
			<Inplace>
				<template #display>
					<div class="flex items-center gap-2">
						<i class="pi pi-plus" />
						<span>New Column</span>
					</div>
				</template>
				<template #content="{ closeCallback }">
					<form @submit.prevent="createTaskList" class="space-y-4">
						<div class="flex flex-col">
							<label for="name">Name</label>
							<InputText
								id="name"
								name="name"
								type="text"
								v-model="form.name"
								autofocus
								:invalid="form.errors.name ? true : false" />
							<InputError :message="form.errors.name" />
						</div>
						<div class="flex justify-end gap-2">
							<Button
								type="button"
								label="Cancel"
								severity="secondary"
								@click="
									() => {
										closeCallback()
										form.reset()
									}
								" />
							<Button type="submit" label="Save" />
						</div>
					</form>
				</template>
			</Inplace>
		</template>
	</Card>
</template>

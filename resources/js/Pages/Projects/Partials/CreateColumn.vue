<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Icon } from '@iconify/vue'
import { Card, CardContent } from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'

const props = defineProps({
	project_id: String,
})

const columnForm = useForm({
	name: '',
	project_id: props.project_id,
})

const addingColumn = ref(false)
const createColumn = () => {
	columnForm.post(route('columns.store'), {
		preserveState: false,
		preserveScroll: true,
	})
}
</script>

<template>
	<form @submit.prevent="createColumn">
		<Card class="w-72">
			<Button
				v-if="!addingColumn"
				type="button"
				variant="ghost"
				@click="addingColumn = true"
				class="w-full justify-start gap-2">
				<Icon icon="lucide:plus" />
				Add another column
			</Button>

			<CardContent v-else class="flex flex-col gap-4 pt-6">
				<div>
					<Label for="name">Title</Label>
					<Input type="text" id="name" name="name" v-model="columnForm.name" />
				</div>
				<div class="flex gap-2">
					<Button type="button" variant="outline" @click="addingColumn = false">
						Cancel
					</Button>
					<Button :disabled="columnForm.processing">Create</Button>
				</div>
			</CardContent>
		</Card>
	</form>
</template>

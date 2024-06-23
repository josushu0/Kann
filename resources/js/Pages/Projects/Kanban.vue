<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Column from '@/Components/Column.vue'
import { router, useForm } from '@inertiajs/vue3'
import { useDragAndDrop } from '@formkit/drag-and-drop/vue'
import { ref } from 'vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Icon } from '@iconify/vue'
import { Card, CardContent } from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'

const props = defineProps({
	project: Object,
	data: Array,
})

const [parent, columns, updateConfig] = useDragAndDrop(props.data, {
	handleEnd: (e) => {
		const index = e.targetData.node.data.index
		const prevCol = columns.value[index - 1]
		const nextCol = columns.value[index + 1]
		const column = e.targetData.node.data.value

		let position = column.position

		if (prevCol && nextCol) {
			position = (prevCol.position + nextCol.position) / 2
		} else if (nextCol) {
			position = nextCol.position / 2
		} else if (prevCol) {
			position = prevCol.position + prevCol.position / 2
		}

		router.put(
			route('columns.move', { column: column.id }),
			{
				position: position,
			},
			{
				preserveState: false,
				preserveScroll: true,
			}
		)
	},
})

const editing = ref(false)
const toggleEditing = () => {
	editing.value = !editing.value
	updateConfig({ disabled: editing.value })
}

const columnForm = useForm({
	name: '',
	project_id: props.project.id,
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
	<AppLayout :title="project.name">
		<div class="flex max-h-full gap-2 px-10">
			<div ref="parent" class="flex h-full gap-2">
				<Column
					v-for="column in columns"
					:key="column.id"
					:column="column"
					@toggle-editing="toggleEditing" />
			</div>
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
							<Input
								type="text"
								id="name"
								name="name"
								v-model="columnForm.name" />
						</div>
						<div class="flex gap-2">
							<Button
								type="button"
								variant="outline"
								@click="addingColumn = false">
								Cancel
							</Button>
							<Button :disabled="columnForm.processing">Create</Button>
						</div>
					</CardContent>
				</Card>
			</form>
		</div>
	</AppLayout>
</template>

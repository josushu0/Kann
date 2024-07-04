<script setup>
import {
	Card,
	CardContent,
	CardHeader,
} from '@/Components/shadcn/ui/card/index.js'
import { router, useForm } from '@inertiajs/vue3'
import {
	DropdownMenu,
	DropdownMenuContent,
	DropdownMenuItem,
	DropdownMenuTrigger,
} from '@/Components/shadcn/ui/dropdown-menu/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Icon } from '@iconify/vue'
import {
	EditableArea,
	EditableInput,
	EditablePreview,
	EditableRoot,
} from 'radix-vue'
import ConfirmActionModal from '@/Components/ConfirmActionModal.vue'
import { useDraggable } from 'vue-draggable-plus'
import { ref } from 'vue'
import KanbanTask from '@/Components/KanbanTask.vue'
import CreateTask from '@/Components/CreateTask.vue'

const props = defineProps({
	column: Object,
	columns: Array,
	canUpdateColumn: Boolean,
	canDeleteColumn: Boolean,
	teamMembers: Array,
})

const form = useForm({
	name: props.column.name,
})

const updateName = () => {
	form.put(route('columns.update', props.column.id), {
		onError: () => (form.name = props.column.name),
	})
}

const deleteColumn = () => {
	router.delete(route('columns.destroy', props.column.id), {
		preserveState: false,
		preserveScroll: true,
	})
}

const draggable = ref(null)
const tasks = ref(props.column.tasks)
useDraggable(draggable, tasks, {
	handle: '.task_drag_handle',
	ghostClass: 'border-primary',
	group: 'tasks',
	onAdd: (e) => {
		const index = e.newIndex
		const prevTask = tasks.value[index - 1]
		const nextTask = tasks.value[index + 1]
		const task = tasks.value[index]

		let position = task.position

		if (prevTask && nextTask) {
			position = (prevTask.position + nextTask.position) / 2
		} else if (nextTask) {
			position = nextTask.position / 2
		} else if (prevTask) {
			position = prevTask.position + prevTask.position / 2
		}

		router.put(
			route('tasks.move', { task: task.id }),
			{
				position: position,
				column_id: props.column.id,
			},
			{
				preserveState: false,
				preserveScroll: true,
			}
		)
	},
	onUpdate: (e) => {
		const index = e.newIndex
		const prevTask = tasks.value[index - 1]
		const nextTask = tasks.value[index + 1]
		const task = tasks.value[index]

		let position = task.position

		if (prevTask && nextTask) {
			position = (prevTask.position + nextTask.position) / 2
		} else if (nextTask) {
			position = nextTask.position / 2
		} else if (prevTask) {
			position = prevTask.position + prevTask.position / 2
		}

		router.put(
			route('tasks.move', { task: task.id }),
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
</script>

<template>
	<Card class="h-fit w-72">
		<CardHeader class="flex h-full flex-row items-start p-4">
			<div
				v-if="canUpdateColumn"
				class="column_drag_handle flex-none cursor-grab p-3">
				<Icon icon="lucide:grip-vertical" />
			</div>
			<EditableRoot
				submit-mode="enter"
				v-model="form.name"
				select-on-focus
				@submit="updateName"
				:disabled="!canUpdateColumn"
				class="flex-1 overflow-hidden break-words">
				<EditableArea>
					<EditablePreview as="h2" class="px-3 py-2 font-semibold" />
					<EditableInput
						class="w-full rounded-md border border-input bg-background px-3 py-2 font-semibold ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50" />
				</EditableArea>
			</EditableRoot>
			<DropdownMenu v-if="canDeleteColumn">
				<DropdownMenuTrigger as-child>
					<Button variant="ghost" size="icon" class="flex-none">
						<Icon icon="lucide:ellipsis-vertical" class="size-4" />
					</Button>
				</DropdownMenuTrigger>
				<DropdownMenuContent>
					<DropdownMenuItem as-child>
						<ConfirmActionModal
							title="Delete column?"
							description="Are you sure you want to delete this column?"
							:button="{
								text: 'Delete',
								variant: 'destructive',
								disabled: form.processing,
							}"
							@confirm="deleteColumn">
							<Button variant="ghost" class="gap-2">
								<Icon icon="lucide:trash" class="text-red-600" />
								Delete column
							</Button>
						</ConfirmActionModal>
					</DropdownMenuItem>
				</DropdownMenuContent>
			</DropdownMenu>
		</CardHeader>
		<CardContent class="flex flex-col gap-2">
			<div ref="draggable" class="flex flex-col gap-2">
				<KanbanTask
					v-for="task in tasks"
					:key="task.id"
					:task="task"
					:column="column.id"
					:columns="columns"
					:teamMembers="teamMembers" />
			</div>
			<CreateTask
				:column="column.id"
				:columns="columns"
				:teamMembers="teamMembers">
				<Button
					type="button"
					variant="ghost"
					class="w-full justify-start gap-2">
					<Icon icon="lucide:plus" />
					Add task
				</Button>
			</CreateTask>
		</CardContent>
	</Card>
</template>

<script setup>
import { Card } from '@/Components/shadcn/ui/card/index.js'
import {
	Sheet,
	SheetContent,
	SheetDescription,
	SheetHeader,
	SheetTitle,
	SheetTrigger,
} from '@/Components/shadcn/ui/sheet/index.js'
import {
	DateFormatter,
	getLocalTimeZone,
	parseDateTime,
	today,
} from '@internationalized/date'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import InputError from '@/Components/InputError.vue'
import { router, useForm } from '@inertiajs/vue3'
import { Textarea } from '@/Components/shadcn/ui/textarea/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import {
	Popover,
	PopoverTrigger,
} from '@/Components/shadcn/ui/popover/index.js'
import { Icon } from '@iconify/vue'
import {
	TagsInput,
	TagsInputInput,
	TagsInputItem,
	TagsInputItemDelete,
	TagsInputItemText,
} from '@/Components/shadcn/ui/tags-input/index.js'
import { ComboboxAnchor, ComboboxInput, ComboboxRoot } from 'radix-vue'
import { computed, ref } from 'vue'
import {
	CommandEmpty,
	CommandGroup,
	CommandItem,
	CommandList,
} from '@/Components/shadcn/ui/command/index.js'
import PopoverContent from './shadcn/ui/popover/PopoverContent.vue'
import Calendar from './shadcn/ui/calendar/Calendar.vue'
import {
	Select,
	SelectTrigger,
	SelectContent,
	SelectGroup,
	SelectItem,
	SelectValue,
} from '@/Components/shadcn/ui/select/index.js'
import ConfirmActionModal from './ConfirmActionModal.vue'

const props = defineProps({
	task: {
		type: Object,
		default: null,
	},
	column: String,
	columns: Array,
	teamMembers: Array,
})

const dateFormatter = new DateFormatter('en-US', { dateStyle: 'medium' })

const form = useForm({
	name: props.task ? props.task.name : '',
	description: props.task ? props.task.description : '',
	due_date: props.task
		? parseDateTime(props.task.due_date)
		: today(getLocalTimeZone()),
	assigned: [],
	column_id: props.column,
})

const teamTags = props.teamMembers.map((member) => {
	return { value: member.id, label: member.name }
})
const searchTerm = ref('')
const filteredMembers = computed(() =>
	teamTags.filter((member) => !form.assigned.includes(member.label))
)

const deleteTask = () => {
	router.delete(route('tasks.destroy', props.task.id), {
		preserveState: false,
		preserveScroll: true,
	})
}

const handleSubmit = () => {
	if (props.task) {
		form
			.transform((data) => ({
				...data,
				due_date: data.due_date.toString(),
			}))
			.put(route('tasks.update', props.task.id), {
				preserveState: false,
				preserveScroll: true,
			})
	} else {
		form
			.transform((data) => ({
				...data,
				due_date: data.due_date.toString(),
			}))
			.post(route('tasks.store'), {
				preserveState: false,
				preserveScroll: true,
			})
	}
}
</script>

<template>
	<Card>
		<Sheet @update:open="form.reset()">
			<SheetTrigger as-child>
				<slot />
			</SheetTrigger>
			<SheetContent>
				<SheetHeader>
					<SheetTitle>{{ task ? task.name : 'Create Task' }}</SheetTitle>
					<SheetDescription v-if="task" class="flex gap-2">
						Created at
						{{
							dateFormatter.format(
								parseDateTime(task.created_at.slice(0, -8)).toDate(
									getLocalTimeZone()
								)
							)
						}}
					</SheetDescription>
				</SheetHeader>
				<form @submit.prevent="handleSubmit" class="mt-3 w-full space-y-4">
					<div>
						<Label for="column">Column</Label>
						<Select
							name="column"
							v-model="form.column_id"
							:default-value="column">
							<SelectTrigger>
								<SelectValue />
							</SelectTrigger>
							<SelectContent>
								<SelectGroup>
									<SelectItem
										v-for="column in columns"
										:key="column.id"
										:value="column.id">
										{{ column.name }}
									</SelectItem>
								</SelectGroup>
							</SelectContent>
						</Select>
					</div>
					<div>
						<Label for="name">Name</Label>
						<Input
							type="text"
							id="name"
							name="name"
							placeholder="Name"
							v-model="form.name" />
						<InputError :message="form.errors.name" class="mt-2" />
					</div>
					<div>
						<Label for="description">Description</Label>
						<Textarea
							id="description"
							name="description"
							placeholder="Description"
							v-model="form.description" />
						<InputError :message="form.errors.description" class="mt-2" />
					</div>
					<div>
						<Label for="due_date">Due Date</Label>
						<Popover>
							<PopoverTrigger as-child>
								<Button variant="outline" class="w-full justify-start gap-3">
									<Icon icon="lucide:calendar" class="size-4" />
									{{
										dateFormatter.format(
											form.due_date.toDate(getLocalTimeZone())
										)
									}}
								</Button>
							</PopoverTrigger>
							<PopoverContent>
								<Calendar v-model="form.due_date" />
							</PopoverContent>
						</Popover>
					</div>
					<div>
						<Label for="assigned">Assigned</Label>
						<ComboboxRoot
							v-model="form.assigned"
							v-model:searchTerm="searchTerm"
							class="w-full">
							<ComboboxAnchor>
								<TagsInput :model-value="form.assigned">
									<TagsInputItem
										v-for="member in form.assigned"
										:key="member"
										:value="member">
										<TagsInputItemText />
										<TagsInputItemDelete />
									</TagsInputItem>
									<ComboboxInput as-child>
										<TagsInputInput
											class="w-full px-3"
											placeholder="Assignees..."
											@keydown.enter.prevent />
									</ComboboxInput>
								</TagsInput>
							</ComboboxAnchor>

							<CommandList
								position="popper"
								:dismissable="true"
								class="z-50 mt-2 w-[--radix-popper-anchor-width] rounded-md border bg-popover text-popover-foreground outline-none data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
								<CommandEmpty />
								<CommandGroup>
									<CommandItem
										v-for="member in filteredMembers"
										:key="member.value"
										:value="member.label"
										@select.prevent="
											(ev) => {
												searchTerm = ''
												form.assigned.push(ev.detail.value)
											}
										">
										{{ member.label }}
									</CommandItem>
								</CommandGroup>
							</CommandList>
						</ComboboxRoot>
					</div>
					<div class="flex justify-between gap-2">
						<ConfirmActionModal
							v-if="task"
							title="Delete Task?"
							description="Are you sure you want to delete this column?"
							:button="{
								text: 'Delete',
								variant: 'destructive',
								disabled: false,
							}"
							@confirm="deleteTask">
							<Button variant="destructive" type="button"> Delete </Button>
						</ConfirmActionModal>
						<div class="flex w-full justify-end gap-2">
							<Button variant="outline" type="button">Cancel</Button>
							<Button type="submit">Save</Button>
						</div>
					</div>
				</form>
			</SheetContent>
		</Sheet>
	</Card>
</template>

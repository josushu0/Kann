<script setup>
import {
	Card,
	CardHeader,
	CardTitle,
} from '@/Components/shadcn/ui/card/index.js'
import { router, useForm } from '@inertiajs/vue3'
import {
	EditableArea,
	EditableInput,
	EditablePreview,
	EditableRoot,
} from 'radix-vue'
import InputError from '@/Components/InputError.vue'
import {
	DropdownMenu,
	DropdownMenuContent,
	DropdownMenuItem,
	DropdownMenuTrigger,
} from '@/Components/shadcn/ui/dropdown-menu/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Icon } from '@iconify/vue'

const props = defineProps({
	column: Object,
})
const emits = defineEmits(['toggleEditing'])

const toggleEditing = () => {
	console.log('editing')
	emits('toggleEditing')
}

const form = useForm({
	name: props.column.name,
})

const updateName = (value) => {
	form.put(route('columns.update', props.column.id))
}

const deleteColumn = () => {
	router.delete(route('columns.destroy', props.column.id), {
		preserveState: false,
		preserveScroll: true,
	})
}
</script>

<template>
	<Card class="flex w-72 select-none flex-col gap-2">
		<CardHeader>
			<CardTitle class="flex items-center justify-between gap-2 text-lg">
				<EditableRoot
					:model-value="form.name"
					submit-mode="both"
					select-on-focus
					@update:model-value="(value) => (form.name = value)"
					@submit="(value) => updateName(value)">
					<EditableArea>
						<EditablePreview as="div" />
						<EditableInput
							class="w-full rounded-md border border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
						<InputError :message="form.errors.name" class="mt-2" />
					</EditableArea>
				</EditableRoot>
				<DropdownMenu>
					<DropdownMenuTrigger as-child>
						<Button variant="ghost" size="icon" class="shrink-0">
							<Icon icon="lucide:ellipsis-vertical" />
						</Button>
					</DropdownMenuTrigger>
					<DropdownMenuContent>
						<DropdownMenuItem
							class="flex items-center gap-2"
							@click="deleteColumn">
							<Icon icon="lucide:trash" class="text-red-600" />
							Delete column
						</DropdownMenuItem>
					</DropdownMenuContent>
				</DropdownMenu>
			</CardTitle>
		</CardHeader>
	</Card>
</template>

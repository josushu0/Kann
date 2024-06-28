<script setup>
import { Card, CardHeader } from '@/Components/shadcn/ui/card/index.js'
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

const props = defineProps({
	column: Object,
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
</script>

<template>
	<Card class="h-fit w-72">
		<CardHeader class="flex h-full flex-row items-start p-4">
			<div class="column_drag_handle flex-none cursor-grab p-3">
				<Icon icon="lucide:grip-vertical" />
			</div>
			<EditableRoot
				submit-mode="enter"
				v-model="form.name"
				select-on-focus
				@submit="updateName"
				class="flex-1 overflow-hidden break-words">
				<EditableArea>
					<EditablePreview as="h3" class="px-3 py-2 font-semibold" />
					<EditableInput
						class="w-full rounded-md border border-input bg-background px-3 py-2 font-semibold ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50" />
				</EditableArea>
			</EditableRoot>
			<DropdownMenu>
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
	</Card>
</template>

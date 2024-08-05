<script setup>
import { computed } from 'vue'
import { Button } from '@/Components/shadcn/ui/button'
import {
	DropdownMenu,
	DropdownMenuContent,
	DropdownMenuItem,
	DropdownMenuSeparator,
	DropdownMenuTrigger,
} from '@/Components/shadcn/ui/dropdown-menu'
import { Icon } from '@iconify/vue'
import {
	Dialog,
	DialogClose,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
	DialogTrigger,
} from '@/Components/shadcn/ui/dialog/index.js'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
	row: Object,
	title: String,
	description: String,
	button: Object
})

const handleDelete = () => {
	router.delete(route('users.destroy', props.row.original), { preserveState: false })
}
</script>

<template>
	<Dialog>
		<DropdownMenu>
			<DropdownMenuTrigger as-child>
				<Button variant="ghost" class="flex size-8 p-0 data-[state=open]:bg-muted">
					<Icon icon="lucide:ellipsis" class="size-4" />
					<span class="sr-only">Open menu</span>
				</Button>
			</DropdownMenuTrigger>
			<DropdownMenuContent align="end" class="w-40">
				<DropdownMenuItem as-child>
					<Link :href="route('users.edit', row.original)">Edit</Link>
				</DropdownMenuItem>
				<DropdownMenuSeparator />
				<DialogTrigger as-child>
					<DropdownMenuItem>
						Delete
					</DropdownMenuItem>
				</DialogTrigger>
			</DropdownMenuContent>
		</DropdownMenu>
		<DialogContent>
			<DialogHeader>
				<DialogTitle>{{ title }}</DialogTitle>
				<DialogDescription>
					{{ description }}
				</DialogDescription>
			</DialogHeader>
			<div class="flex justify-end gap-2">
				<DialogClose as-child>
					<Button variant="outline">Cancel</Button>
				</DialogClose>
				<Button :variant="button.variant || 'default'" :disabled="button.disabled || false" @click="handleDelete">
					{{ button.text }}
				</Button>
			</div>
		</DialogContent>
	</Dialog>
</template>

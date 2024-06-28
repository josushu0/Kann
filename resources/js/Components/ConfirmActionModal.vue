<script setup>
import {
	Dialog,
	DialogClose,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
	DialogTrigger,
} from '@/Components/shadcn/ui/dialog/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

defineProps({
	title: String,
	description: String,
	button: Object,
})
defineEmits(['confirm'])
</script>

<template>
	<Dialog>
		<DialogTrigger as-child>
			<slot />
		</DialogTrigger>
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
				<Button
					:variant="button.variant || 'default'"
					:disabled="button.disabled || false"
					@click="$emit('confirm')">
					{{ button.text }}
				</Button>
			</div>
		</DialogContent>
	</Dialog>
</template>

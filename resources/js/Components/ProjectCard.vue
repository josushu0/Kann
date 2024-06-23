<script setup>
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from '@/Components/shadcn/ui/card/index.js'
import { Icon } from '@iconify/vue'
import { Link } from '@inertiajs/vue3'

defineProps({
	project: Object,
})
</script>

<template>
	<Link :href="route('projects.show', project.id)">
		<Card class="group select-none">
			<CardHeader>
				<div class="flex justify-between gap-2">
					<CardTitle>{{ project.name }}</CardTitle>
					<Icon
						icon="lucide:chevron-right"
						class="size-8 translate-y-1 opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100" />
				</div>
			</CardHeader>
			<CardContent>
				<CardDescription class="truncate">
					{{ project.description }}
				</CardDescription>
			</CardContent>
		</Card>
	</Link>
</template>

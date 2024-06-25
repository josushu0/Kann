<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from '@/Components/shadcn/ui/card/index.js'
</script>

<template>
	<AppLayout title="Settings">
		<div class="grid place-content-center">
			<Card>
				<CardHeader>
					<CardTitle>Create a new project</CardTitle>
					<CardDescription>
						Your project will be contained within an organization. Every user in
						the organization will have access to this project.
					</CardDescription>
				</CardHeader>
				<CardContent>
					<form @submit.prevent="createProject" class="w-full space-y-4"></form>
				</CardContent>
			</Card>
		</div>
	</AppLayout>
</template>

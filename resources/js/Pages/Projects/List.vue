<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ProjectCard from '@/Components/ProjectCard.vue'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Icon } from '@iconify/vue'
import { ref, watch } from 'vue'
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from '@/Components/shadcn/ui/card/index.js'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
	projects: {
		type: Array,
	},
	canCreateProject: {
		type: Boolean,
	},
})

const filteredProjects = ref(props.projects)
const search = ref('')

watch(search, (value) => {
	if (search.value.length > 0) {
		filteredProjects.value = filteredProjects.value.filter((project) =>
			project.name.toLowerCase().includes(search.value.toLowerCase())
		)
	} else {
		filteredProjects.value = props.projects
	}
})
</script>

<template>
	<AppLayout title="Projects">
		<div class="container space-y-4">
			<div class="flex gap-2">
				<Label for="search_project" class="sr-only">Search Projects</Label>
				<Input
					type="text"
					id="search_project"
					name="search_project"
					placeholder="Search Projects..."
					v-model="search" />
				<Button v-if="canCreateProject" as-child>
					<Link
						:href="route('projects.create')"
						class="flex items-center gap-1">
						<Icon icon="lucide:plus" class="size-5" />
						Create Project
					</Link>
				</Button>
			</div>
			<div
				v-if="projects.length > 0"
				class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
				<ProjectCard
					v-for="project in filteredProjects"
					:key="project.id"
					:project="project" />
			</div>
			<div v-else>
				<Card>
					<CardHeader class="items-center">
						<CardTitle>No Projects</CardTitle>
						<CardDescription v-if="canCreateProject">
							Get started by creating a new project.
						</CardDescription>
						<CardDescription v-else>
							Only Administrators can create new projects.
						</CardDescription>
					</CardHeader>
					<CardContent v-if="canCreateProject" class="flex justify-center">
						<Button as-child>
							<Link
								:href="route('projects.create')"
								class="flex items-center gap-1">
								<Icon icon="lucide:plus" class="size-5" />
								Create Project
							</Link>
						</Button>
					</CardContent>
				</Card>
			</div>
		</div>
	</AppLayout>
</template>

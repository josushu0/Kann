<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import {
	Card,
	CardContent,
	CardHeader,
	CardTitle,
} from '@/Components/shadcn/ui/card/index.js'
import {
	DateFormatter,
	getLocalTimeZone,
	parseDateTime,
} from '@internationalized/date'
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/Components/shadcn/ui/popover/index.js'
import { Icon } from '@iconify/vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Link, router, useForm } from '@inertiajs/vue3'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Textarea } from '@/Components/shadcn/ui/textarea/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import InputError from '@/Components/InputError.vue'
import { RangeCalendar } from '@/Components/shadcn/ui/range-calendar/index.js'
import { ref } from 'vue'
import ConfirmsPassword from '@/Components/ConfirmsPassword.vue'
import { Separator } from '@/Components/shadcn/ui/separator/index.js'

const props = defineProps({
	project: Object,
	canUpdateProject: Boolean,
})

const dateFormatter = new DateFormatter('en-US', { dateStyle: 'medium' })

const date = ref({
	start: parseDateTime(props.project.start_date),
	end: parseDateTime(props.project.end_date),
})

const form = useForm({
	name: props.project.name,
	description: props.project.description,
	start_date: '',
	end_date: '',
})

const updateProject = () => {
	form
		.transform((data) => ({
			...data,
			start_date: date.value.start.toString(),
			end_date: date.value.end.toString(),
		}))
		.put(route('projects.update', props.project.id))
}

const deleteProject = () => {
	router.delete(route('projects.destroy', props.project.id))
}
</script>

<template>
	<AppLayout :title="project.name" :project="project.id">
		<Card
			class="mx-auto w-full max-w-3xl border-0 shadow-none md:border md:shadow-sm">
			<CardHeader>
				<CardTitle>Project Settings</CardTitle>
			</CardHeader>
			<CardContent>
				<form @submit.prevent="updateProject" class="w-full space-y-4">
					<div>
						<Label for="name">Name</Label>
						<Input
							type="text"
							id="name"
							name="name"
							placeholder="Name"
							:disabled="!canUpdateProject"
							v-model="form.name" />
						<InputError :message="form.errors.name" class="mt-2" />
					</div>
					<div>
						<Label for="description">Description</Label>
						<Textarea
							id="description"
							name="description"
							placeholder="Describe your project..."
							:disabled="!canUpdateProject"
							v-model="form.description" />
						<InputError :message="form.errors.description" class="mt-2" />
					</div>
					<div>
						<Label for="time">Time Range</Label>
						<Popover>
							<PopoverTrigger as-child>
								<Button
									variant="outline"
									:disabled="!canUpdateProject"
									class="w-full justify-start gap-3">
									<Icon icon="lucide:calendar" class="size-4" />
									<template v-if="date.start">
										<template v-if="date.end">
											{{
												dateFormatter.format(
													date.start.toDate(getLocalTimeZone())
												)
											}}
											-
											{{
												dateFormatter.format(
													date.end.toDate(getLocalTimeZone())
												)
											}}
										</template>
										<template v-else>
											{{
												dateFormatter.format(
													date.start.toDate(getLocalTimeZone())
												)
											}}
										</template>
									</template>
									<span v-else class="text-muted-foreground">
										Pick a time range
									</span>
								</Button>
							</PopoverTrigger>
							<PopoverContent>
								<RangeCalendar
									v-model="date"
									@update:start-value="(start) => (date.start = start)" />
							</PopoverContent>
						</Popover>
						<InputError :message="form.errors.start_date" class="mt-2" />
					</div>
					<div class="flex justify-end gap-2">
						<Button variant="outline" type="submit">
							<Link :href="route('projects.show', project.id)">Cancel</Link>
						</Button>
						<Button
							v-if="canUpdateProject"
							type="submit"
							:disabled="form.processing || !canUpdateProject">
							Update
						</Button>
					</div>
				</form>
			</CardContent>

			<Separator />

			<!-- Danger zone -->
			<CardHeader>
				<CardTitle>Danger Zone</CardTitle>
			</CardHeader>
			<CardContent class="flex flex-col justify-between gap-4 sm:flex-row">
				<div>
					<h4 class="font-semibold">Delete this project</h4>
					<p>
						Once you delete a repository, there is no going back. Please be
						certain.
					</p>
				</div>
				<ConfirmsPassword
					title="Delete this project"
					:content="`This will permanently delete the ${project.name} project and tasks. This action is not reversible, please be certain.`"
					button="Delete project"
					always-ask
					@confirmed="deleteProject">
					<Button variant="destructive">Delete project</Button>
				</ConfirmsPassword>
			</CardContent>
		</Card>
	</AppLayout>
</template>

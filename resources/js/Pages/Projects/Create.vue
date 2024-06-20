<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Link, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import { Textarea } from '@/Components/shadcn/ui/textarea/index.js'
import { DateFormatter, getLocalTimeZone } from '@internationalized/date'
import { ref } from 'vue'
import { Icon } from '@iconify/vue'
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/Components/shadcn/ui/popover/index.js'
import { RangeCalendar } from '@/Components/shadcn/ui/range-calendar/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const form = useForm({
	name: '',
	description: '',
	start_date: '',
	end_date: '',
})

const dateFormatter = new DateFormatter('en-US', { dateStyle: 'medium' })

const date = ref({
	start: '',
	end: '',
})

const createProject = () => {
	form
		.transform((data) => ({
			...data,
			start_date: date.value.start.toDate(),
			end_date: date.value.end.toDate(),
		}))
		.post(route('projects.store'))
}
</script>

<template>
	<AppLayout title="Create Project">
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
					<form @submit.prevent="createProject" class="w-full space-y-4">
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
								placeholder="Describe your project..."
								v-model="form.description" />
							<InputError :message="form.errors.description" class="mt-2" />
						</div>
						<div>
							<Label for="time">Time Range</Label>
							<Popover>
								<PopoverTrigger as-child>
									<Button variant="outline" class="w-full justify-start gap-3">
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
							<Button variant="outline">
								<Link :href="route('projects.index')">Cancel</Link>
							</Button>
							<Button type="submit" :disabled="form.processing">Create</Button>
						</div>
					</form>
				</CardContent>
			</Card>
		</div>
	</AppLayout>
</template>

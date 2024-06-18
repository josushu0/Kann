<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import {
	Card,
	CardContent,
	CardDescription,
} from '@/Components/shadcn/ui/card/index.js'
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

const props = defineProps({
	team: Object,
})

const form = useForm({})
const open = ref(false)

const deleteTeam = () => {
	form.delete(route('teams.destroy', props.team), {
		errorBag: 'deleteTeam',
		onFinish: () => (open.value = false),
	})
}
</script>

<template>
	<div class="grid gap-4 md:grid-cols-3">
		<div>
			<h2 class="font-bold">Delete Team</h2>
			<p class="text-sm">Permanently delete this team.</p>
		</div>

		<Card class="col-span-2">
			<CardContent class="mt-6 space-y-4">
				<CardDescription>
					Once a team is deleted, all of its resources and data will be
					permanently deleted. Before deleting this team, please download any
					data or information regarding this team that you wish to retain.
				</CardDescription>
				<div class="flex items-center justify-end gap-2">
					<Dialog v-model:open="open">
						<DialogTrigger as-child>
							<Button variant="destructive">Delete Team</Button>
						</DialogTrigger>
						<DialogContent>
							<DialogHeader>
								<DialogTitle>Delete Team</DialogTitle>
								<DialogDescription>
									Are you sure you want to delete this team? Once a team is
									deleted, all of its resources and data will be permanently
									deleted.
								</DialogDescription>
							</DialogHeader>
							<div class="flex justify-end gap-2">
								<DialogClose as-child>
									<Button variant="outline">Cancel</Button>
								</DialogClose>
								<Button
									variant="destructive"
									:disabled="form.processing"
									@click="deleteTeam">
									Delete
								</Button>
							</div>
						</DialogContent>
					</Dialog>
				</div>
			</CardContent>
		</Card>
	</div>
</template>

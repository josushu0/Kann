<script setup>
import { Icon } from '@iconify/vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import TaskForm from '@/Components/TaskForm.vue'
import { Avatar, AvatarImage } from './shadcn/ui/avatar';

const props = defineProps({
	task: Object,
	column: String,
	columns: Array,
	isAdmin: Boolean,
	teamMembers: Array,
})
</script>

<template>
	<TaskForm :task="task" :column="column" :columns="columns" :teamMembers="teamMembers" :isAdmin="isAdmin">
		<Button variant="ghost" class="flex w-full select-none justify-start p-3 h-fit">
			<div v-if="task.assigned === $page.props.auth.user.id || isAdmin"
				class="task_drag_handle flex-none cursor-grab pe-3">
				<Icon icon="lucide:grip-vertical" />
			</div>
			<div class="flex flex-col gap-2 w-full items-start overflow-hidden">
				<p class="text-wrap text-start break-words">{{ task.name }}</p>
				<Avatar v-if="task.assigned" class="size-6">
					<AvatarImage :src="teamMembers.find(member => task.assigned === member.id).avatar" />
				</Avatar>
			</div>
		</Button>
	</TaskForm>
</template>

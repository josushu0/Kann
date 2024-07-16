<script setup lang="ts">
import { ref } from 'vue'
import InputError from './InputError.vue'

defineProps<{
	error: string | undefined
	processing: boolean
	triggerLabel: string
	severity?:
		| 'danger'
		| 'secondary'
		| 'success'
		| 'info'
		| 'warn'
		| 'help'
		| 'contrast'
	header?: string
	content?: string
	actionLabel: string
}>()

defineEmits(['confirm'])

const modal = ref(false)
const password = ref()
</script>

<template>
	<Button
		:label="triggerLabel"
		:severity="severity || undefined"
		@click="modal = true" />
	<Dialog class="max-w-lg" v-model:visible="modal" modal :header="header">
		<div class="flex flex-col">
			<p class="text-muted-color">
				{{ content }}
			</p>
		</div>
		<div class="mt-4">
			<label for="password" class="sr-only">Password</label>

			<Password
				class="w-full"
				placeholder="Password"
				id="password"
				v-model="password"
				:feedback="false"
				:invalid="error ? true : false"
				:pt="{ pcInput: { root: { class: 'w-full' } } }"
				@keyup.enter="$emit('confirm', password)" />

			<InputError :message="error" />
		</div>

		<div class="mt-4 flex justify-end gap-2">
			<Button
				outlined
				@click="modal = false"
				severity="secondary"
				label="Cancel" />

			<Button
				:disabled="processing"
				severity="danger"
				:label="actionLabel"
				@click="$emit('confirm', password)" />
		</div>
	</Dialog>
</template>

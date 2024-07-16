export interface User {
	id: number
	name: string
	email: string
	email_verified_at: string
	avatar: string
	title: string
	department: string
	phone: string
	created_ad: string
}

export type PageProps<
	T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
	auth: {
		user: User
	}
}

export interface Links {
	active: boolean
	label: string
	url: string
}

export interface UserPaginator {
	current_page: number
	data: User[]
	first_page_url: string
	from: number
	last_page: number
	last_page_url: string
	links: Links[]
	next_page_url: string
	path: string
	per_page: number
	prev_page_url: string
	to: number
	total: number
}

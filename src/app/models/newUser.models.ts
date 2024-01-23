export interface NewUser {
     name: string,
     nickname: string,
     email: string,
     password: string,
     institution: string,
     is_proffessional: boolean
}

export interface Profile {
     type: string,
     value: string,
     user_id: number
}

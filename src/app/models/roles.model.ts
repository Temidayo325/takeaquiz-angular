export interface UserRoles{
     editor: boolean,
     admin: boolean,
     author: boolean
}

export interface Roles
{
     id: number,
     role: string,
     pivot?: object
}

export interface Result {
     user_id: number,
     score: number,
     topic_id: number,
     proffessional_status: Boolean,
     question_ids? : string
}

export interface MarkedResult
{
     score: number,
     grade: string,
     opinion: string,
     date: string,
     topic: string
}

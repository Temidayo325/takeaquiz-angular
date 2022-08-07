import { Component, OnInit } from '@angular/core';
import { ToastService } from 'angular-toastify';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { TrueorfalseService } from '../Services/trueorfalse.service'
import { FormBuilder, Validators } from '@angular/forms';

@Component({
  selector: 'app-truth-orfalse',
  templateUrl: './truth-orfalse.component.html',
  styleUrls: ['./truth-orfalse.component.scss']
})
export class TruthOrfalseComponent implements OnInit {
     addQuestionForm = this.fb.group({
         course: ['', [Validators.required]],
         id: [''],
         display_token: ['', [Validators.required, Validators.minLength(6)]],
         question: ['', [Validators.required, Validators.minLength(6)]],
         mark: ['1', [Validators.required, Validators.minLength(1)]],
         answer: ['', [Validators.required, Validators.minLength(2)]],
         assesment_id: ['1']
     });
  constructor(
       private toast: ToastService,
       private loading: LoadingBarService,
       private questionService: TrueorfalseService,
       private fb: FormBuilder
 ) { }
   public display: any =  {questionForm: false, showForm: false, display_token: '', edit: false, question: []}
   public courseDetail: any = {course: '', display_token: '', button: false, index: 0, question: {}}
   public sub : any
   public courses: Array<any> = []
   public questions: Array<number> = []
   public returnedQuest: Array<any> = []
   public answers: Array<any> = []
   public marks: Array<number> = []
   public errors: any = []
   public view: any = {edit: false, view: false, add: false, questions: []}
   public assesment_ids: Array<number> = []
   // public currentAssesment: number = 1
  ngOnInit(): void {
       this.getCourse()
  }
  getCourse()
  {
       this.loading.start()
       this.sub = this.questionService.coursesAndQuestions().subscribe(
            (res: any) => {
                 this.loading.complete()
                 if (res.success) {
                      if (res.courses.length > 0) {
                           this.courses = res.courses
                           this.generateAssesmentId(res.courses)
                           res.questions.map((value: any, index: number) => {
                                console.log(res.questions)
                               if (value.question == null) {
                                    this.questions.push(0)
                                    this.marks.push(0)
                                    this.returnedQuest.push([])
                               }else{
                                    for (const [key, corresponding] of Object.entries(value.question))
                                    {
                                         this.view.questions.push(corresponding)
                                    }
                                    this.returnedQuest.push(this.view.questions)
                                    this.questions.push(this.view.questions.length)
                                    let total = 0
                                    this.view.questions.map( (currentValue: any, currentIndex: number) => {
                                         total += parseInt(currentValue.mark)
                                    })
                                    this.marks.push(total)
                               }
                               this.view.questions = []
                           })
                      }
                      if (res.questions.length == 0) {

                      }
                 }
            },
            (err: any) => {
                 this.loading.complete()
                 this.toast.warn(err.error.message)
            }
       )
  }
  public generateAssesmentId(values: Array<any>)
  {
       values.forEach((item: any, index: number) => {
            item.assesment.forEach( (value:any) => {
                 if (!this.assesment_ids.includes(value.numb)) {
                    this.assesment_ids.push(value.numb)
                }
                if (this,this.assesment_ids.length == 0) {
                    this.assesment_ids.push(1)
                }
            });
       })

       if (this.assesment_ids.length == 0) {
            this.assesment_ids.push(1)
       }
  }
  public courseAdded(value: boolean)
  {
       this.display.showForm = false
       this.getCourse()
  }
  viewQuestion(index: number)
  {
       this.view.questions = this.returnedQuest[index]
       this.view.add = false
       this.view.view = true
       this.view.edit = false
       this.courseDetail.course = this.courses[index].course
       this.courseDetail.index = index
       this.courseDetail.display_token = this.courses[index].display_token
       this.display.edit = true
  }
  closeSideModal()
  {
       this.getCourse()
       this.display.edit = false
  }
  addQuestionToggle(index: number, display_token: string)
  {
       this.view.view = false
       this.view.edit = false
       this.courseDetail.display_token = display_token
       this.courseDetail.index = index
       this.courseDetail.course = this.courses[index].course
       this.addQuestionForm.patchValue({
            course: this.courses[index].course, display_token: display_token
       })
       this.view.add = true
       this.display.edit = true
  }
  editQuestion(question: any)
  {
       this.addQuestionForm.patchValue({
            course: this.courseDetail.course, id: question.id,
           display_token: this.courseDetail.display_token,
           question: question.question,
           mark: question.mark,
           answer: question.answer
       })
       this.courseDetail.question = question
       // console.log(this.courseDetail.question)
       this.courseDetail.button = true
       this.view.view = false
       this.view.add = true
  }
  deleteQuestion(question: any, index: number)
  {
       this.loading.start()
       if (confirm("Are you sure you want to delete the question? Action cannot be reversed")) {
            this.questionService.deleteQuestions(question, this.courseDetail.display_token).subscribe(
                 (res) => {
                     this.toast.info(res.message)
                     // Remove the deleted item from the array of questions
                     let getIndex = this.view.questions.indexOf(question)
                     this.view.questions.splice(getIndex, 1)
                     this.loading.complete()
                     this.addQuestionForm.reset()
                 },
                 (err) => {
                      this.toast.warn(err.error.message)
                      console.log(err)
                      this.loading.complete()
                 }
            )
       }
  }
  saveQuestion()
  {
       this.loading.start()
       if (this.returnedQuest[this.courseDetail.index].length > 0) {
            this.questionService.updateQuestions(this.addQuestionForm.value).subscribe(
                 (res) => {
                      this.toast.success(res.message)
                      this.loading.complete()
                      this.addQuestionForm.patchValue({
                           question: '', answer: ''
                      })
                      this.errors = []
                 },
                 (err) => {
                      this.loading.complete()
                      console.log(err)
                      this.toast.info(err.error.message)
                      this.errors = err.error.errors
                 }
            )
       }
       if (this.returnedQuest[this.courseDetail.index].length == 0) {
            this.questionService.addQuestions(this.addQuestionForm.value).subscribe(
                 (res) => {
                      this.toast.success(res.message)
                      this.loading.complete()
                      this.addQuestionForm.patchValue({
                           question: '', answer: ''
                      })
                 },
                 (err) => {
                      this.loading.complete()
                      console.log(err)
                      this.toast.info(err.error.message)
                      this.errors = err.error.errors
                 }
            )
       }

  }
  saveEditedQuestion()
  {
       this.questionService.editQuestions(this.addQuestionForm.value).subscribe(
            (res) => {
                 this.toast.success(res.message)
                 // SPlice the question with that id
                 let getIndex = this.view.questions.indexOf(this.courseDetail.question)
                 this.view.questions.splice(getIndex, 1, this.addQuestionForm.value)
                 this.courseDetail.button = false
                 this.view.view = true
                 this.view.add = false
                 this.view.edit = false
                 this.loading.complete()
                 this.addQuestionForm.reset()

            },
            (err) => {
                 this.loading.complete()
                 console.log(err)
                 this.toast.info(err.error.message)
                 this.errors = err.error.errors
            }
       )
  }
  public trackByFn(index: any, item: any):number
  {
    return index;
  }
}

import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { QuestionsService } from '../Services/questions.service';
import { CourseService } from '../Services/course.service';
import { ToastService } from 'angular-toastify';
import { Router } from '@angular/router';
import { LoadingBarService } from '@ngx-loading-bar/core';

@Component({
  selector: 'app-question',
  templateUrl: './question.component.html',
  styleUrls: ['./question.component.scss']
})
export class QuestionComponent implements OnInit {

     addQuestionForm = this.fb.group({
         course: ['', [Validators.required]],
         id: [''],
         display_token: ['', [Validators.required, Validators.minLength(6)]],
         question: ['', [Validators.required, Validators.minLength(6)]],
         option1: ['', [Validators.required, Validators.minLength(2)]],
         option2: ['', [Validators.required, Validators.minLength(2)]],
         option3: ['', [Validators.required, Validators.minLength(9)]],
         option4: ['', [Validators.required, Validators.minLength(2)]],
         answer: ['', [Validators.required, Validators.minLength(2)]],
         assesment_id: ['1']
     });

  constructor(
       private fb : FormBuilder,
       private question: QuestionsService,
       private course: CourseService,
       private toast: ToastService,
       private router: Router,
       private loading: LoadingBarService,
 ) { }

  ngOnInit(): void {
       this.loading.start()
       this.getCourse()
       this.countQuestion()
       this.coursesAndQuestions()
       this.loading.complete()
  }
  public edit: boolean = false
  public sub: any
  public overview: any = [
       {number: 0, text: 'Available courses'},
       {number: 0, text: 'Available questions'}
  ]
  public view: any = {edit: false, view: false, add: false, questions: []}
  public courseDetail: any = {course: '', display_token: '', button: false, index: 0}
  public courses: any = []
  public questions: any = []
  public assesment_ids: Array<number> = []
  public errors: any = []
  getCourse()
  {
       this.loading.start()
       this.sub = this.course.getTyped('mcq').subscribe(
            (res) => {
                 if (res.statusCode == 200) {
                      this.courses = res.course
                      this.loading.complete()
                      this.overview[0].number = res.course.length
                 }
            },
            (err) => {
                 this.loading.complete()
                 this.toast.warn(err.error.message)
            }
       )
  }
  countQuestion()
  {
       this.loading.start()
       this.sub = this.question.getCount().subscribe(
           (res) => {
                this.loading.complete()
               this.overview[1].number = res.count
           },
           (err) => {
                this.loading.complete()
                this.toast.info(err.error.message)
           }
      )
  }
  coursesAndQuestions()
  {
       this.loading.start()
       this.sub = this.question.typedcoursesAndQuestions('mcq').subscribe(
            (res) => {
                 this.loading.complete()
                 this.courses = res.courses
                 this.questions = res.questions
                 this.generateAssesmentId(res.courses)
            },
            (err) => {
                 this.loading.complete()
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

  viewQuestions(questions: number, option: string, course: string, display_token: string)
  {
       if (option === 'edit') {

       }else if(option === 'view')
       {
            this.view.view = true
            this.view.edit = false
            this.view.add = false
            this.courseDetail.course = course
            this.courseDetail.display_token = display_token
            this.view.questions = questions
            this.edit = true
       }

  }
  public trackByFn(index: any, item: any):number
  {
    return index;
  }
  addQuestionToggle(display_token: string, course: string)
  {
       this.view.view = false
       this.view.edit = false
       this.view.add = true
       this.addQuestionForm.patchValue({
            course: course,
            display_token: display_token
       })
       this.courseDetail.display_token = display_token
       this.courseDetail.course = course
      this.edit =  true
  }
  addQuestion()
  {
       this.loading.start()
       this.sub = this.question.addQuestion(this.addQuestionForm.value).subscribe(
            (res) => {
                 this.loading.complete()
                 this.toast.success(res.message)
                 this.addQuestionForm.reset()
                 this.addQuestionForm.patchValue({display_token: this.courseDetail.display_token, assesment_id: 1, course: this.courseDetail.course})
            },
            (err) => {
                 this.loading.complete()
                 this.errors = err.error.errors
                 this.toast.warn(err.error.message)
            }
       )
  }
  closeSideBar()
  {
      this.countQuestion()
      this.coursesAndQuestions()
      this.edit = !this.edit
  }
  editQuestion(question: any)
  {
       this.addQuestionForm.patchValue({
            question: question.question, option1: question.option1, option2: question.option2,
            option3: question.option3, option4: question.option4, answer: question.answer,
            id: question.id, type: question.type, display_token: this.courseDetail.display_token, course: this.courseDetail.course, assesment_id: question.assesment_id
       });
       this.courseDetail.index = this.view.questions.indexOf(question)
       // console.log(this.view.questions)
       this.courseDetail.button = !this.courseDetail.button
       this.view.add = false
       this.view.view = false
       this.view.add = true
  }
  saveEditedQuestion()
  {
       this.loading.start()
       this.sub = this.question.editQuestion(this.addQuestionForm.value).subscribe(
            (res) => {
                 this.loading.complete()
                 this.toast.success(res.message)
                 this.view.questions.fill(this.addQuestionForm.value, this.courseDetail.index, this.courseDetail.index+1)
                 this.addQuestionForm.reset();
                 this.courseDetail.button = !this.courseDetail.button
                 this.view.add = false
                 this.view.view = true
                 this.view.add = false
            },
            (err) => {
                 this.loading.complete()
                 this.errors = err.error.errors
                 this.toast.warn(err.error.message)
            }
       )
  }
  deleteQuestion(question: any, index: number)
  {
       this.loading.start()
       this.sub = this.question.deleteQuestion(this.courseDetail.display_token, question.id).subscribe(
            (res: any) => {
                 this.loading.complete()
                 this.toast.success(res.message)
                 // this.view.questions.splice(index, 1)
                 const ind = this.view.questions.indexOf(question)
                 this.view.questions.splice(this.view.questions.indexOf(question), 1)
                 this.overview[1].number -= 1
            },
            (err) => {
                 this.loading.complete()
                 this.toast.warn(err.error.message)
            }
       )
  }
  ngOnDestroy(): void
  {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.sub !== undefined  ) {
            this.sub.unsubscribe()
       }
  }
}

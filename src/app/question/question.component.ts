import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { QuestionsService } from '../Services/questions.service';
import { CourseService } from '../Services/course.service';
import { ToastService } from 'angular-toastify';

@Component({
  selector: 'app-question',
  templateUrl: './question.component.html',
  styleUrls: ['./question.component.scss']
})
export class QuestionComponent implements OnInit {

     addQuestionForm = this.fb.group({
         course: ['', [Validators.required]],
         display_token: ['', [Validators.required, Validators.minLength(6)]],
         question: ['', [Validators.required, Validators.minLength(6)]],
         option1: ['', [Validators.required, Validators.minLength(2)]],
         option2: ['', [Validators.required, Validators.minLength(2)]],
         option3: ['', [Validators.required, Validators.minLength(9)]],
         option4: ['', [Validators.required, Validators.minLength(2)]],
         answer: ['', [Validators.required, Validators.minLength(2)]],
         type: ['', [Validators.required, Validators.minLength(2)]],
     });

  constructor(
       private fb : FormBuilder,
       private question: QuestionsService,
       private course: CourseService,
       private toast: ToastService
 ) { }

  ngOnInit(): void {
       this.getCourse()
       this.countQuestion()
       this.coursesAndQuestions()
  }
  public edit: boolean = false
  public sub: any
  public overview: any = [
       {number: 0, text: 'Available courses'},
       {number: 0, text: 'Available questions'},
       // {number: 0, text: 'Completed courses'}
  ]
  public view: any = {edit: false, view: false, add: false, questions: []}
  public courses: any = []
  public questions: any = []
  public errors: any = []
  getCourse()
  {
       this.sub = this.course.get().subscribe(
            (res) => {
                 if (res.statusCode == 200) {
                      // console.log(res.course)
                      this.overview[0].number = res.course.length
                 }
            },
            (err) => {
                 this.toast.warn(err.error.message)
            }
       )
  }
  countQuestion()
  {
       this.question.getCount().subscribe(
           (res) => {
               this.overview[1].number = res.count
           },
           (err) => {
                console.log(err)
                this.toast.info(err.error.message)
           }
      )
  }
  coursesAndQuestions()
  {
       this.question.coursesAndQuestions().subscribe(
            (res) => {
               this.courses = res.courses
               this.questions = res.questions
            },
            (err) => {
                 console.log(err)
            }
       )
  }
  viewQuestions(questions: number, option: string)
  {
       // this.edit = true
       if (option === 'edit') {

       }else if(option === 'view')
       {
            this.view.view = true
            this.view.edit = false
            this.view.add = false
            this.view.questions = questions
            this.edit = true
       }

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
      this.edit =  true
  }
  addQuestion()
  {
       // console.log(this.addQuestionForm.value)
       this.sub = this.question.addQuestion(this.addQuestionForm.value).subscribe(
            (res) => {
                 console.log(res)
                 this.toast.success(res.message)
                 this.addQuestionForm.patchValue({
                      question: '', option1: '', option2: '',
                      option3: '', options4: '', answer: ''
                 });
            },
            (err) => {
                 console.log(err)
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
}

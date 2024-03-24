import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { QuestionModel } from './../models/QuestionModel';
import { QuestionsService } from '../Services/questions.service';
import { CourseService } from '../Services/course.service';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';

@Component({
  selector: 'app-essay-component',
  templateUrl: './essay-component.component.html',
  styleUrls: ['./essay-component.component.scss']
})
export class EssayComponentComponent implements OnInit {

     questionForm = this.fb.group({
          question: ['', [Validators.required, Validators.minLength(10)]],
          scheme: ['', [Validators.required, Validators.minLength(10)]],
          display_token: ['', [Validators.required, Validators.minLength(4)]],
          allotted_mark: [1, [Validators.required, Validators.minLength(1)]]
     });

  constructor(
       private fb : FormBuilder,
       private router: Router,
       private questionService: QuestionsService,
       private courseService: CourseService,
       private loading: LoadingBarService,
       private toast: ToastService,
 ) { }
     public questions: Array<QuestionModel> = []
     public generatedAnswer: string = ''
     public sub: any
     public isLoaded: boolean = false
     public courses: Array<any> = []

  ngOnInit(): void
  {
       this.getCourse()
  }

  submitQuestion()
  {
       this.questions.push({...this.questionForm.value, generated_answer: this.generatedAnswer})
       this.questionService.addEssayQuestion( {...this.questionForm.value, generated_answer: this.generatedAnswer} ).subscribe(
            (response) => {
                 console.log(response)
                 this.questionForm.reset()
            },

            (error) => {
                 console.log(error)
            }
       )

  }

  trackByFn(index: any, item: any):number
  {
       return index;
  }

  generateAnswerWithAi()
  {

  }

  getCourse()
  {
       this.loading.start()
       this.sub = this.courseService.getTyped('essay').subscribe(
            (res: any) => {
                 if (res.statusCode == 200) {
                    this.courses = res.courses
                    this.isLoaded = true
                    this.loading.complete()
                 }
            },
            (err: any) => {
                 this.loading.complete()
                 this.toast.warn(err.error.message)
            }
       )
  }
  selectedCourse($event:any)
  {
       // Get the selected courseS
       const selectedCourse: Array<any> = this.courses.map( (course) => {
            if(course.display_token === $event.target.value)
            {
                 return course;
            }
       })
       this.questions = selectedCourse[0].questions
      console.log(selectedCourse)
  }
}

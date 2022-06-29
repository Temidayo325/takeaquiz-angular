import { Component, OnInit } from '@angular/core';
import { ToastService } from 'angular-toastify';
import { CourseService } from '../Services/course.service'
import { QuestionsService } from '../Services/questions.service'
import { LoadingBarService } from '@ngx-loading-bar/core';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-add-calculation',
  templateUrl: './add-calculation.component.html',
  styleUrls: ['./add-calculation.component.scss']
})

export class AddCalculationComponent implements OnInit {

  constructor(
       private toast: ToastService,
       private questionService: QuestionsService,
       private course: CourseService,
       private loading: LoadingBarService,
       private titleservice : Title,
  ) {}

  public question: string = ''
  public courses: any = []
  public newQuestion: boolean = true
  public finalCopy: Array<{step: string, mark: number, alternative: string}> = []
  public overallContainer: Array<any> = []
  public eachQuestion: any = {step: '', mark: 0, alternative: ''}
  protected sub: any
  public title: string = "Theory Courses"
  ngOnInit(): void
  {
       this.loading.start()
       this.getCourse()
       this.loading.complete()
  }
  public getCourse()
  {
       this.loading.start()
       this.sub = this.course.getTheory().subscribe(
            (res) => {
                 if (res.statusCode == 200) {
                      this.courses = res.course
                      // console.log(res.course)
                      this.loading.complete()
                 }
            },
            (err) => {
                 console.log(err)
                 this.loading.complete()
                 this.toast.warn(err.error.message)
            }
       )
  }
  public addScheme():void
  {
       if (this.question.length < 3) {
            this.toast.warn("Invalid question added")
       }else{
            this.newQuestion = false
       }
  }
  public addStep():void
  {
       if (this.eachQuestion.step.length <= 2 || this.eachQuestion.mark < 0) {
            this.toast.warn("Invalid step and/or Mark")
       }else{
            const cleaned = {step: this.eachQuestion.step.replace(/[-+=/*]/g, (match: any, offset: number, string: string) => {
                 return (offset > 0 ? ' ' : '' ) + match + ' '
            }), mark: this.eachQuestion.mark, alternative: (this.eachQuestion.alternative.length > 0) ? this.eachQuestion.alternative.replace(/[-+=/%()*]/g, (match: any, offset: number, string: string) => {
                 return (offset > 0 ? ' ' : '' ) + match + ' '
            }) : ''}
            this.finalCopy.push({...cleaned})
            this.resetStep()
       }
       console.log(this.finalCopy)
  }
  public savePrevQuest():void
  {
       // make a request to the database
       this.overallContainer.push({question: this.question, steps: this.finalCopy})
       this.sub = this.questionService.addTheoryQuestion({question: this.question, answer: this.finalCopy}).subscribe(
            (res) => {
                 console.log(res)
            },
            (err) => {
                 console.log(err)
                 this.toast.warn(err.error.message)
            }
       )
  }
  protected resetStep():void
  {
       this.eachQuestion.step = ''
       this.eachQuestion.mark = 0
       this.eachQuestion.alternative = ''
  }
  protected cleanString(match: any, offset: number, string: string):string
  {
       return (offset > 0 ? ' ' : '' ) + match + ' '
  }
  public trackByFn(index: any, item: any):number
  {
    return index;
  }
  public addQuestionToggle()
  {

  }
  ngOnDestroy(): void
  {
       if (this.sub !== undefined  ) {
            this.sub.unsubscribe()
       }
  }
}

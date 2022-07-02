import { Component, OnInit } from '@angular/core';
import { QuestionsService } from '../Services/questions.service';
// import { QuestionsService } from '../Services/question.service';
import { ToastService } from 'angular-toastify';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-german',
  templateUrl: './german.component.html',
  styleUrls: ['./german.component.scss']
})
export class GermanComponent implements OnInit {

  constructor(
       private questionService: QuestionsService,
       // private course: CourseService,
       private toast: ToastService,
       private loading: LoadingBarService,
       private title: Title
  ) {
       this.title.setTitle("German questions")
 }

  public sub: any
  public question: string = ''
  public answer: any = {word: '', mark: 0}
  public correction: any = {word: '', mark: 0}
  public available_marks: Array<number> = [0,1,2,3,4,5]
  public createNewQuestion: boolean = false
  public finalCopy: any = []
  public totalMarks: number = 0
  public edited: boolean =  false
  public courses: Array<any> = []
  public questions: Array<any> = []
  public answers: Array<[]> = []
  public marks: Array<number> = []
  public display: any =  {questionForm: false, showForm: false, display_token: ''}
  ngOnInit(): void
  {
       this.getCourse()
  }
  getCourse()
  {
       this.loading.start()
       this.sub = this.questionService.germanCoursesAndQuestions().subscribe(
            (res: any) => {
                 if (res.statusCode == 200) {
                     // console.log(res)
                     this.courses = res.courses
                     this.questions = res.questions[0];
                     this.questions.map((value: any, index: number) => {
                         this.answers.push(JSON.parse(value.answer))
                     })
                     this.questions.map( (value: any, index: number) => {
                          const answers = JSON.parse(value.answer)
                          let total = 0
                          answers.map( (currentValue: any, currentIndex: number) => {
                               total += parseInt(currentValue.mark)
                          })
                          this.marks.push(total)
                     })
                     this.loading.complete()
                 }
            },
            (err: any) => {
                 this.loading.complete()
                 this.toast.warn(err.error.message)
            }
       )
  }
  public createGerman()
  {
       this.question = this.question + "$#"+ parseInt(this.finalCopy.length+1)
       this.createNewQuestion = true;
  }
  public addScheme()
  {
       this.finalCopy.push({...this.answer, edited: false})
       this.totalMarks += parseInt(this.answer.mark)
       this.createNewQuestion = false;
       this.clearForm()
       console.log(this.finalCopy)
  }
  public addQuestion(index: number, display_token: string)
  {
       this.display.questionForm = !this.display.questionForm
       this.display.display_token = display_token
       this.question = this.questions[index].question
       this.totalMarks = this.marks[index]
       this.finalCopy = JSON.parse(this.questions[index].answer)
       console.log(this.questions)
  }
  public trackByFn(index: any, item: any):number
  {
    return index;
  }
  editAnswer(index: number):void
  {
       this.finalCopy[index].edited = !this.finalCopy[index].edited
       this.correction.word = this.finalCopy[index].word
       this.correction.mark = this.finalCopy[index].mark
       console.log(index)
  }
  saveAnswer(index: number):void
  {
       this.finalCopy.splice(index, 1, {...this.correction, edited: false})
       console.log(this.finalCopy)
  }
  clearForm():void
  {
       this.answer.word = ''
       this.answer.mark = 0
       this.correction.word = ''
       this.correction.mark = 0
  }
  saveGerman():void
  {
       this.sub = this.questionService.addGermanQuestion({question: this.question, answer: JSON.stringify(this.finalCopy), display_token: this.display.display_token}).subscribe(
            (res) => {
                 this.toast.info(res.message)
            },
            (err) => {
                 this.toast.warn(err.error.message)
            }
       )
  }
  ngOnDestroy(): void
  {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.sub !== undefined) {
            this.sub.unsubscribe()
       }
  }
}

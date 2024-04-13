import { Component, OnInit } from '@angular/core';
import { QuestionsService } from '../Services/questions.service';
import { ToastService } from 'angular-toastify';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { Title } from '@angular/platform-browser';
import { CourseService } from '../Services/course.service';
// import { slideInRightAnimation, slideOutRightAnimation } from 'angular-animations';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
@Component({
  selector: 'app-german',
  templateUrl: './german.component.html',
  styleUrls: ['./german.component.scss'],
  animations: [
    // slideInRightAnimation({duration: 2000}),
    // slideOutRightAnimation()
  ]
})
export class GermanComponent implements OnInit {

  constructor(
       private questionService: QuestionsService,
       private course: CourseService,
       private toast: ToastService,
       private loading: LoadingBarService,
       private title: Title,
       private http: HttpClient
  ) {
       this.title.setTitle("Fill-in-the-blanks questions")
 }

  public sub: any
  public question: string = ''
  public answer: any = {word: '', mark: 0, synonyms: '', assesment_id: 1, }
  public correction: any = {word: '', mark: 0, synonyms: false, assesment_id: 1}
  public available_marks: Array<number> = [0,1,2,3,4,5]
  public createNewQuestion: boolean = false
  public finalCopy: any = []
  public totalMarks: number = 0
  public edited: boolean =  false
  public courses: Array<any> = []
  public questions: Array<any> = []
  public answers: Array<[]> = []
  public marks: Array<number> = []
  public display: any =  {questionForm: false, showForm: false, display_token: '', edit: false, question: ''}
  public CourseTitle: string = ''
  public assesment_ids: Array<number> = []
  private options = {
      headers : new HttpHeaders({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers': 'Origin, Content-Type, X-Auth-Token'
      }),
 }
  ngOnInit(): void
  {
       this.getCourse()
  }
  getCourse()
  {
       this.loading.start()
       this.sub = this.course.getTyped('german').subscribe(
            (res: any) => {
                 if (res.statusCode == 200) {
                     this.courses = res.courses
                     // this.generateAssesmentId(res.courses)
                     // this.questions = res.questions[0];
                     // if (this.questions.length >= 1) {
                     //      this.questions.map((value: any, index: number) => {
                     //          this.answers.push(JSON.parse(value.answer))
                     //      })
                     //      this.questions.map( (value: any, index: number) => {
                     //           const answers = JSON.parse(value.answer)
                     //           let total = 0
                     //           answers.map( (currentValue: any, currentIndex: number) => {
                     //                total += parseInt(currentValue.mark)
                     //           })
                     //           this.marks.push(total)
                     //      })
                     // }else{
                     //      this.marks.push(0)
                     //      this.answers.push([])
                     // }

                     this.loading.complete()
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
  public createGerman()
  {
       // this.question = this.question + "$#"+ parseInt(this.finalCopy.length+1) + "$#"
       this.question = this.question + " $#$#$# "
       this.createNewQuestion = true;
  }
  public addScheme()
  {
            this.finalCopy.push({...this.answer, edited: false})
            this.totalMarks += parseInt(this.answer.mark)
            this.createNewQuestion = false;
            const answer : string  = (this.answer.synonym != '') ? this.answer.word + ',' + this.answer.synonyms : this.answer.word;
            this.saveGerman(answer)
            this.clearForm()
  }

  public addQuestion(index: number, display_token: string, course:any)
  {
       this.display.display_token = display_token
       this.question = (this.questions.length > 0) ? this.questions[index].question : ''
       this.totalMarks = this.marks[index]
       this.finalCopy = (this.questions.length > 0) ? JSON.parse(this.questions[index].answer) : []
       this.display.questionForm = !this.display.questionForm
       this.CourseTitle = course.course
  }
  public viewQuestion(index: number)
  {
       // Add the html entity character for bold to the replaced string
       if (this.questions.length == 0) {
             this.display.question = "You have not set the question. Close  the modal and click on the add button corresponding with the course to add questions"
       }else{
            this.display.question = (this.questions[index].question.length > 0 ) ? this.questions[index].question.replace(/[$#$#$#]/g, (match: any, offset: number, string: string) => {
                 return (offset > 0 ? '--------' : '' )
            }) : "You have not set the question. Close  the modal and click on the add button corresponding with the course to add questions"
       }

       this.display.edit = !this.display.edit
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
       this.answer.synonyms = ''
       this.answer.mark = 0
       this.correction.word = ''
       this.correction.mark = 0
       this.answer.synonyms = false
       this.correction.synonyms = false
  }
  saveGerman(answer: string):void
  {
       this.sub = this.questionService.addGermanQuestion({question: this.question, answer: JSON.stringify(answer), display_token: this.display.display_token, assesment_id: this.answer.assesment_id}).subscribe(
            (res) => {
                 this.toast.info(res.message)
                 this.getCourse()
            },
            (err) => {
                 this.toast.warn(err.error.message)
            }
       )
  }
  public closeModal()
  {
       this.display.questionForm = false
       this.getCourse()
  }

  public generateSynonym()
  {
       // console.log(this.answer)
       if(this.answer.word.length > 2)
       {
            alert(this.answer);
            this.course.generateSynonym({word: this.answer.word, display_token: this.display.display_token}).subscribe(
                 (response) => {
                      this.answer.synonyms = response.synonyms
                 },
                 (error) => {
                      alert("there was an error in your script")
                      console.log(error)
                 }
            )
       }
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

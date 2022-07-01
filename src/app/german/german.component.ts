import { Component, OnInit } from '@angular/core';
import { QuestionsService } from '../Services/questions.service';
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
       private toast: ToastService,
       private loader: LoadingBarService,
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
  ngOnInit(): void {
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
       this.sub = this.questionService.addTheoryQuestion({question: this.question, answer: JSON.stringify(this.finalCopy)}).subscribe(
            (res) => {

            },
            (err) => {

            }
       )
  }
  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.sub !== undefined) {
            this.sub.unsubscribe()
       }
  }
}

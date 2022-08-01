import { Component, OnInit } from '@angular/core';
import { DomSanitizer, SafeResourceUrl, SafeUrl} from '@angular/platform-browser';
import { InputComponent } from '../input/input.component';

@Component({
  selector: 'app-test',
  templateUrl: './test.component.html',
  styleUrls: ['./test.component.scss']
})
export class TestComponent implements OnInit {

  constructor(
       private sanitizer: DomSanitizer
 ) { }
  public model: any = {question: ' $#$#$# is the first man to be created along with his wife $#$#$#. They gave birth to $#$#$# sons. After them, came a great hunter named $#$#$# . The oldest of that era was named $#$#$# who lived to be $#$#$#', total: 6}
  question: any
  answer: Array<any> = []

  ngOnInit(): void
  {
       for (let index = 0; index < this.model.total; index++) {
            let provided = {questionNumber: index+1, value: ''}
            this.answer.push(provided)
       }
       console.log(this.answer)
       this.question = this.sanitizer.bypassSecurityTrustHtml(this.model.question.replace(/\$\#\$\#\$\#/g, (match: any, offset: number, string: string) => {
            return (offset > 0 ? '<input class="spans py-2 px-2 bg-gray-100 border-0 inline-block"/>' : '' )
       }))
  }
  public enterAnswer()
  {
     alert("Clicked me")
  }
  Submitted()
  {
       let spans = document.querySelectorAll('.spans')
       spans.forEach((element: any, index: number, arr) => {
            this.answer[index].value = element.innerText
       });
       console.log(this.answer)
  }
}

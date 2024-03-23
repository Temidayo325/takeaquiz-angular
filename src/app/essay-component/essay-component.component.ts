import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { QuestionModel } from './../models/QuestionModel';

@Component({
  selector: 'app-essay-component',
  templateUrl: './essay-component.component.html',
  styleUrls: ['./essay-component.component.scss']
})
export class EssayComponentComponent implements OnInit {

     questionForm = this.fb.group({
          question: ['', [Validators.required, Validators.minLength(10)]],
          scheme: ['', [Validators.required, Validators.minLength(10)]],
          allotted_mark: [1, [Validators.required, Validators.minLength(1)]]
     });

  constructor(
       private fb : FormBuilder,
       private router: Router,
 ) { }
     public questions: Array<QuestionModel> = []

  ngOnInit(): void
  {
  }

  submitQuestion()
  {
       console.log(this.questionForm.value)
       this.questions.push(this.questionForm.value)
       this.questionForm.reset()
  }

  trackByFn(index: any, item: any):number
  {
       return index;
  }
}

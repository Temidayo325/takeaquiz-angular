import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { QuestionService } from './../../services/question.service';
import { StoreService } from './../../service/store.service';
import { Router } from '@angular/router';
import { Subject, Observable, of, Subscription } from 'rxjs';
// import { ShareService } from './../../services/share.service';
import {Title} from '@angular/platform-browser';

@Component({
  selector: 'app-question',
  templateUrl: './question.component.html',
  styleUrls: ['./question.component.css']
})
export class QuestionComponent implements OnInit {

     form = new FormGroup({
            "topic_id": new FormControl("", [Validators.required]),
            "question": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "option1": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "option2": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "option3": new FormControl("", [Validators.nullValidator]),
            "option4": new FormControl("", [Validators.nullValidator]),
            "answer": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "type": new FormControl("", [Validators.required, Validators.minLength(4)]),
    });

    formByFile = new FormGroup({
         "topic_id": new FormControl("", [Validators.required]),
         "file": new FormControl("", [Validators.required]),
    });

    public error: any = []
    public subs!: Subscription;
    public topics = JSON.parse(sessionStorage.getItem('topics')!)
    public createByForm = false
    public roles = this.storeService.getUserRoles()
    public methodType: boolean = false
    public questionAudience: string = ''
    public text: string = ''
    public modules = { toolbar: {
                container: '#toolbar',  // Selector for toolbar container
                toolbar:  ['bold', 'italic', 'underline', 'strike']
          }}
    // public_
  constructor(
       private questionService: QuestionService,
       private storeService: StoreService,
       // private share: ShareService,
       private loader: LoadingBarService,
       private toast: ToastService,
       private router: Router,
       private title: Title
 ) {
      this.title.setTitle("Create new questions")
 }

  ngOnInit(): void
  {
       this.form.patchValue({type: "word"});
       this.questionAudience = ( !this.roles.admin ) ? 'student' : '' 
       console.log(this.roles)
  }
  get question() { return this.form.get('question'); }
  get topic_id() { return this.form.get('topic_id'); }
  get option1() { return this.form.get('option1'); }
  get option2() { return this.form.get('option2'); }
  // get option3() { return this.form.get('option3'); }
  // get option4() { return this.form.get('option4'); }
  get answer() { return this.form.get('answer'); }
  get file() {return this.formByFile.get('file'); }

  fileName: string = 'No file uploaded yet.'
  excelFile!: File

  chooseQuestionType(event: any)
  {
       this.methodType = event.target.value == 'true' ? true : false
  }

  chooseQuestionAudience(event: any)
  {
       this.questionAudience = event.target.value
  }

  onSubmit()
  {
       this.loader.start()
       const topic_id = this.form.value.topic_id
       this.subs = this.questionService.createFromForm({...this.form.value}, this.questionAudience).subscribe(
            (response: any) => {
                 this.loader.complete()
                 this.toast.info(response.message)
                 this.error = []
                this.form.reset()
                this.form.patchValue({type: "word", topic_id: topic_id})
            },
            (error: any) => {
                 this.loader.complete()
                 this.toast.warn(error.error.message)
                 this.error = error.error.errors
            }
       )
  }
  filePicked(event: any)
  {
       this.fileName = event.target.files[0].name
       this.excelFile = event.target.files[0]
       this.formByFile.patchValue({file: this.fileName})
  }

  ngSubmitfile()
  {
       this.loader.start()
       this.subs = this.questionService.createFromFile(this.excelFile, this.formByFile.value.topic_id, {topic_id:this.formByFile.value.topic_id, question: this.excelFile }, this.questionAudience).subscribe(
            (response: any) => {
                 this.loader.complete()
                 this.toast.info(response.message)
                 this.error = []
                this.form.reset()
                this.form.patchValue({type: "word", topic_id: this.formByFile.value.topic_id})
                this.router.navigate(['/admin/dashboard/home'])
            },
            (error: any) => {
                 this.loader.complete()
                 this.toast.warn(error.error.message)
                 this.error = error.error.errors
            }
       )
  }
  trackByFn(index: number, topic: any)
  {
        return topic ? topic.id : undefined;
    }
  ngOnDestroy(): void
  {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.subs) {
            this.subs.unsubscribe()
       }
  }
}

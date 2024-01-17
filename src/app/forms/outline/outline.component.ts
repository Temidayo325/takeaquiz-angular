import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import {Title} from '@angular/platform-browser';
import { ContentService } from './../../services/content.service';
import { ShareService } from './../../services/share.service';

@Component({
  selector: 'app-outline',
  templateUrl: './outline.component.html',
  styleUrls: ['./outline.component.css']
})
export class OutlineComponent implements OnInit {

  form = new FormGroup({
     "outline": new FormControl("", [Validators.required, Validators.minLength(4)]),
  });

  constructor(
       private loader: LoadingBarService,
       private toast: ToastService,
       private title: Title,
       private share: ShareService,
       private content: ContentService
 ) {
      this.title.setTitle("Add Topic outline")
 }

  get outline() { return this.form.get('outline'); }
  @Input() topic_id :number = 0
  @Output() AddedOutline = new EventEmitter<string>()

  ngOnInit(): void
  {
       this.share.getTopicId().subscribe(
            (response: any) => {
                 this.topic_id = response
            }
       )
  }

  onSubmit():void
  {
       this.loader.start()
       if (this.topic_id === 0) {
            this.loader.complete()
            this.toast.error("Outline cannot be added to Invalid topic")
       }
       this.content.post({topic_id: this.topic_id, content: this.form.value.outline}).subscribe(
            (response) => {
                 this.loader.complete()
                 this.AddedOutline.emit(this.form.value.outline!)
                 this.form.reset()
            },
            (error) => {
                 this.loader.complete()
                 this.toast.error("Invalid request")
            }
       )
  }
}

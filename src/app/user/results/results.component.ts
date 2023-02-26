import { Component, OnInit,  Output, EventEmitter  } from '@angular/core';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { UserService } from './../../service/user.service';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import {Title} from '@angular/platform-browser';
import { ShareService } from './../../services/share.service';
import { TopicService } from './../../services/topic.service';

@Component({
  selector: 'app-results',
  templateUrl: './results.component.html',
  styleUrls: ['./results.component.css']
})
export class ResultsComponent implements OnInit {

   @Output() headerEvent = new EventEmitter<string>();

  constructor(
       private userService: UserService,
       private topicService: TopicService,
       private loader: LoadingBarService,
       private router: Router,
       private toast: ToastService,
       private title: Title,
       private sharedService: ShareService
 ) {
      this.title.setTitle("Assessment results")
      this.sharedService.newHeader.next("My Results")
 }
  public results: Array<any> = []
  public user: any = JSON.parse(sessionStorage.getItem('user')!)

  ngOnInit(): void
  {
       this.headerEvent.emit(`Results`)
       this.loader.start()
       this.results = JSON.parse(sessionStorage.getItem('results')!)
       this.userService.getResults(this.user.id).subscribe(
            (response: any) => {
                 this.loader.complete()
                 this.results = response.results
                 sessionStorage.setItem('results', JSON.stringify(response.results))
            },
            (error) => {

            }
       )
  }
  trackByFn(index: number, result: any)

  {
        return result ? result.id : undefined;
  }

  shareAssessment(id$: number)
  {
       // send a request to create the code
       this.topicService.shareAssessment(id$).subscribe(
            (response: any) => {
                 // Generate a full-link
                 let link = "https://quizly.luminaace.com/share/result/"+ response.data.code
                 // generate copy
                 let copy = "Check out the result of an assessment I just took on Quizly. "+ link
                 // Copy link + copy to the clipboard
                 console.log(response)
                 try{
                      navigator.clipboard.writeText(copy)
                      this.toast.info("Link has been copied to your clipboard, paste on any of your social media to share")
                 }catch(err){
                      this.toast.warn("Unable to copy shared assessment")
                 }
                 // Let the user know that the content is available on the clipboard

            },

            (error) => {
                 this.toast.error("Unable to generate sharable link")
                 console.log(error)
            }
       )
       // Retrieve the code and save the link and the writeup to the clipboard
       // the content of the clipboard can be shared across platforms
  }
}

import { Component, OnInit,  Output, EventEmitter  } from '@angular/core';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { UserService } from './../../service/user.service';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import {Title} from '@angular/platform-browser';
import { ShareService } from './../../services/share.service';

@Component({
  selector: 'app-results',
  templateUrl: './results.component.html',
  styleUrls: ['./results.component.css']
})
export class ResultsComponent implements OnInit {

   @Output() headerEvent = new EventEmitter<string>();

  constructor(
       private userService: UserService,
       private loader: LoadingBarService,
       private router: Router,
       private toast: ToastService,
       private title: Title,
       private sharedService: ShareService
 ) {
      this.title.setTitle("Assessment results")
      this.sharedService.newHeader.next("Results")
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
}

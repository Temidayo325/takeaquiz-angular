import { Component, OnInit } from '@angular/core';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { UserService } from './../../service/user.service';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';

@Component({
  selector: 'app-results',
  templateUrl: './results.component.html',
  styleUrls: ['./results.component.css']
})
export class ResultsComponent implements OnInit {

  constructor(
       private userService: UserService,
       private loader: LoadingBarService,
       private router: Router,
       private toast: ToastService
 ) { }
  public results: Array<any> = JSON.parse(sessionStorage.getItem('results')!)

  ngOnInit(): void
  {
       this.userService.getResults().subscribe(
            (response: any) => {
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

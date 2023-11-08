import { Component, OnInit } from '@angular/core';
import { PubllicService } from './../services/publlic.service';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor(
       private publicService: PubllicService,
 ) { }

  public statistics: any = {topics: 0, users: 0, assessments: 0}
  public sub!: Subscription
  ngOnInit(): void
  {
       this.sub  = this.publicService.domainStat().subscribe(
            (response) => {
                 console.log(response)
                 this.statistics = response.data
          },
          (error) => {
               console.log(error)
          }
       )
  }

  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       // this.sub.unsubscribe()
  }
}

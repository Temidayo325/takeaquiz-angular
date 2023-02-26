import { Component, OnInit, Input } from '@angular/core';
import { trigger, state, style, animate, transition, } from '@angular/animations';

@Component({
  selector: 'app-success',
  templateUrl: './success.component.html',
  styleUrls: ['./success.component.css'],
  animations: [
   trigger("openClose", [
          state('open', style({
               transform: 'translateY(0)',
          })),
          state('close', style({
               transform: 'translateY(-100%)',
          })),
          transition("open <=> close", animate("300ms linear"))
   ])
    ]
})
export class SuccessComponent implements OnInit {

  constructor() { }

  @Input() display: boolean = true
  @Input() text: string = "The action was a success"

  ngOnInit(): void {
  }
  closeModal()
  {
          this.display = false
  }
}

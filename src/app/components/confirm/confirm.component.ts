import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { trigger, state, style, animate, transition, } from '@angular/animations';

@Component({
  selector: 'app-confirm',
  templateUrl: './confirm.component.html',
  styleUrls: ['./confirm.component.css'],
  animations: [
    trigger("openClose", [
          state('open', style({
               transform: 'translateY(0)',
          })),
          state('close', style({
               transform: 'translateY(100%)',
          })),
          transition("open <=> close", animate("300ms linear"))
    ])
     ]
})
export class ConfirmComponent implements OnInit {

  constructor() { }

  @Input() display: boolean = true
  @Input() yes: string = ''
  @Input() no: string = ''
  @Input() text: string = "Do you want to continue with the selected action ?"

  @Output() actionEvent = new EventEmitter<boolean>()

  ngOnInit(): void {
  }

  closeModal()
  {
          this.display = false
  }
  positive()
  {
     this.actionEvent.emit(true)
  }

  negative()
  {
       this.actionEvent.emit(false)
  }
}

import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { AdminLoginComponent } from './admin-login/admin-login.component';
import { DashboardComponent } from './admin/dashboard/dashboard.component';
import { TopicComponent } from './forms/topic/topic.component';
import { QuestionComponent } from './forms/question/question.component';
import { VerifyQuestionComponent } from './admin/verify-question/verify-question.component';
const routes: Routes = [
     { path: 'index', component: HomeComponent },
     {path: 'login', component: LoginComponent},
     {path: 'admin', component: AdminLoginComponent},
     {path: 'admin/dashboard', component: DashboardComponent,
          children: [
               {
                    path: 'forms/topic',
                    component: TopicComponent
               },
               {
                    path: 'forms/question',
                    component: QuestionComponent
               },
               {
                    path: 'topic/:id',
                    component: VerifyQuestionComponent
               }
          ]},
     { path: '', redirectTo: '/index', pathMatch: 'full' },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

Lecture System

setup:
   install apache mysql. 
   create mysql 
      user:     lecture_system 
      passwd:   lecture_sql
      database: lecture
   dump data.sql into database ('lecture')

run:
   link lecture_2 into ~/public_html/
   website: localhost/~user/lecture_2

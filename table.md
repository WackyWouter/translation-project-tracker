This is a mockup of how the table is gonna look

Project Type column consisting of the options: Translation, QM, Tracked Changes, PE, Other
progress Type column consisting of the options: Assigned, Files Available, In Progress, Completed, Issue, Unconfirmed

Order by due date in the database and then show that as the initial ordering. 
The # column will not be the id of the project as it needs to only counting the ones for the day so most likely index +1 

By default dont show the start Date and due Date column. Add a button that toggles them.

<!-- Every day will have its own table - day is decided by planned_date -->
| #   | Project Title | Project Type | Source Lang | Target Lang | Start Date | Start Time | Due Date  | Due Time  | Wordcount | Progress | 
| --- | ------------- | ------------ | ----------- | ----------- | ---------- | ---------- | --------- | ----- | --------- | -------- |
| 1   | Title         | QM           |  Norwegian  |  English    | 01-10-2022 | 10:10      | 01-10-200 | 17:00 | 300       |  Issue   |
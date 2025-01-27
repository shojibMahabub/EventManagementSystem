# EventManagementSystem


## HOST - http://47.129.224.127/

### **Epic 1: User Authentication**
- **Task_001:** Set up database schema for users (fields: username, email, password, etc.).
- **Task_002:** Implement user registration with secure password hashing.
- **Task_003:** Implement user login functionality.
- **Task_004:** Add server-side validation for registration and login forms.
- **Task_005:** Build responsive UI for login and registration pages.
- **Task_006:** Create session management for authenticated users.

---

### **Epic 2: Event Management**
- **Task_007:** Design database schema for events (fields: name, description, date, capacity, etc.). [x] Done
- **Task_008:** Create functionality for adding new events. [x] Done
- **Task_009:** Implement edit functionality for events. [x] Done
- **Task_010:** Create delete functionality for events. [x] Done
- **Task_011:** Add server-side validation for event creation and updates. [x] Done
- **Task_012:** Develop a responsive UI for creating and managing events. [x] Done

---

### **Epic 3: Attendee Registration**
- **Task_013:** Design database schema for attendees (fields: name, email, event_id, etc.).
- **Task_014:** Implement attendee registration form linked to specific events.
- **Task_015:** Add server-side validation for registration forms.
- **Task_016:** Prevent registrations beyond event capacity.
- **Task_017:** Develop a responsive UI for attendee registration.

---

### **Epic 4: Event Dashboard**
- **Task_018:** Build a paginated list view of events.
- **Task_019:** Add sorting functionality for event fields (name, date, etc.).
- **Task_020:** Implement filtering options for events (e.g., by date, capacity).
- **Task_021:** Develop a responsive UI for the event dashboard.

---

### **Epic 5: Event Reports**
- **Task_022:** Create functionality to export attendee lists to CSV format.
- **Task_023:** Ensure the download functionality is available only to admins.
- **Task_024:** Design a simple UI for admins to select events for report generation.

---

### **Epic 6: Security Enhancements**
- **Task_025:** Ensure all user inputs are validated client-side and server-side.
- **Task_026:** Use prepared statements for database queries to prevent SQL injection.
- **Task_027:** Review and implement secure session handling practices.

---

### **Epic 7: Hosting and Documentation**
- **Task_028:** Deploy the project on a hosting platform (Heroku, Vercel, etc.). \check
- **Task_029:** Prepare a README file with:
  - Project overview
  - Features [x] Done
  - Installation instructions
  - Login credentials for testing
  - Live demo link [x] Done
- **Task_030:** Upload the complete project to GitHub.

---

### **Epic 8: Bonus Features**
- **Task_031:** Implement search functionality for events and attendees.
- **Task_032:** Use AJAX for a smooth attendee registration experience.
- **Task_033:** Develop a JSON API endpoint to fetch event details.

---

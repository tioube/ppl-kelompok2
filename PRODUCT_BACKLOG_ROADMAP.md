# Product Backlog & Roadmap
## Sistem Informasi Akademik SMA

---

## 📋 Informasi Dokumen

**Versi:** 1.0  
**Tanggal:** 22 April 2026  
**Product Owner:** [Nama PO]  
**Scrum Master:** [Nama SM]  

---

## 🎯 Product Vision

> Menyediakan platform terpadu untuk mengelola seluruh aspek akademik SMA dengan otomasi cerdas, akses real-time, dan user experience yang excellent, sehingga meningkatkan efisiensi operasional sekolah dan kualitas pendidikan.

---

## 📅 Roadmap 2026

```
Q2 2026 (Apr-Jun)          Q3 2026 (Jul-Sep)          Q4 2026 (Oct-Dec)          Q1 2027 (Jan-Mar)
├─────────────────┤        ├─────────────────┤        ├─────────────────┤        ├─────────────────┤
│ PHASE 1         │        │ PHASE 2         │        │ PHASE 3         │        │ ENHANCEMENT     │
│ Foundation ✅   │        │ Core Features   │        │ Advanced        │        │ Polish & Scale  │
│                 │        │                 │        │                 │        │                 │
│ • Auth & RBAC   │        │ • Nilai         │        │ • Reporting     │        │ • Mobile App    │
│ • User Mgmt     │        │ • Absensi       │        │ • Analytics     │        │ • Multi-tenant  │
│ • Data Akademik │        │ • Pengumuman    │        │ • Mobile Opt    │        │ • API v2        │
│ • Scheduling    │        │ • Notifications │        │ • PWA           │        │ • AI Features   │
│ • Dashboards    │        │                 │        │ • Integration   │        │                 │
└─────────────────┘        └─────────────────┘        └─────────────────┘        └─────────────────┘
```

---

## 🗂️ Product Backlog (Prioritized)

### Priority: 🔴 CRITICAL - Must Have (Phase 1) ✅

| ID | Epic/Feature | Story Points | Status | Sprint | Notes |
|----|--------------|--------------|--------|--------|-------|
| EP-001 | Authentication & Authorization | 21 | ✅ DONE | 1 | Laravel Breeze + Custom RBAC |
| EP-002 | User Management | 13 | ✅ DONE | 1-2 | CRUD Users dengan role assignment |
| EP-003 | Data Akademik Master | 34 | ✅ DONE | 2-3 | Tahun Ajaran, Jurusan, Kelas, Mapel |
| EP-004 | Guru & Siswa Management | 21 | ✅ DONE | 3-4 | Integration dengan users table |
| EP-005 | Dashboard System | 21 | ✅ DONE | 4 | 5 Role-specific dashboards |
| EP-006 | Advanced Scheduling | 34 | ✅ DONE | 5-6 | Auto-generate + Manual editing |

**Total Phase 1:** 144 Story Points ✅

---

### Priority: 🟠 HIGH - Should Have (Phase 2) 📋

| ID | Epic/Feature | Story Points | Status | Sprint | Target Date | Notes |
|----|--------------|--------------|--------|--------|-------------|-------|
| EP-007 | Nilai/Grades Management | 34 | 📋 TODO | 7-8 | Jun 2026 | Input nilai + Rapor calculation |
| EP-008 | Absensi/Attendance | 34 | 📋 TODO | 9-10 | Jul 2026 | Input absensi + Rekap + Notifikasi |
| EP-009 | Pengumuman & Communication | 21 | 📋 TODO | 11 | Ago 2026 | Announcement system + Notifications |

**Total Phase 2:** 89 Story Points 📋

---

### Priority: 🟡 MEDIUM - Could Have (Phase 3) 📋

| ID | Epic/Feature | Story Points | Status | Sprint | Target Date | Notes |
|----|--------------|--------------|--------|--------|-------------|-------|
| EP-010 | Reporting & Analytics | 34 | 📋 TODO | 12-13 | Sep 2026 | Advanced reports + Analytics dashboard |
| EP-011 | Mobile Optimization & PWA | 21 | 📋 TODO | 14 | Okt 2026 | Responsive + PWA + Install prompt |
| EP-012 | Integration & API | 21 | 📋 TODO | 15 | Nov 2026 | REST API + DAPODIK integration |

**Total Phase 3:** 76 Story Points 📋

---

### Priority: 🟢 LOW - Nice to Have (Future) 📋

| ID | Epic/Feature | Story Points | Status | Target Date | Notes |
|----|--------------|--------------|--------|-------------|-------|
| EP-016 | Native Mobile App | 55 | 📋 FUTURE | Q1 2027 | React Native/Flutter |
| EP-017 | Multi-tenant System | 34 | 📋 FUTURE | Q1 2027 | Support multiple schools |
| EP-018 | AI-Powered Features | 55 | 📋 FUTURE | Q2 2027 | Predictive analytics, recommendations |
| EP-019 | E-Learning Integration | 34 | 📋 FUTURE | Q2 2027 | LMS integration, online classes |
| EP-020 | Keuangan/Finance Module | 55 | 📋 FUTURE | Q3 2027 | SPP, pembayaran, kasir |

**Total Future:** 233 Story Points 📋

---

### Ongoing: ♾️ CONTINUOUS

| ID | Epic/Feature | Priority | Status | Notes |
|----|--------------|----------|--------|-------|
| EP-013 | Testing & QA | 🟠 HIGH | 🚧 IN PROGRESS | Continuous testing |
| EP-014 | Documentation & Training | 🟡 MEDIUM | 📋 TODO | User & dev docs |
| EP-015 | Performance & Security | 🟠 HIGH | 📋 TODO | Continuous optimization |

---

## 📈 Release Plan

### Release 1.0 - MVP (June 2026) 🎯

**Target:** Sistem dasar yang functional untuk digunakan di sekolah

**Included Features:**
- ✅ Authentication & RBAC
- ✅ User Management (5 roles)
- ✅ Data Akademik Master
- ✅ Guru & Siswa Management
- ✅ Advanced Scheduling System
- ✅ Role-specific Dashboards
- 🚧 Nilai/Grades Management
- 🚧 Basic Reporting

**Success Criteria:**
- Semua fitur Phase 1 completed
- 70% test coverage
- No critical bugs
- Documentation 80% complete
- Training conducted

**Release Date:** 30 Juni 2026

---

### Release 1.1 - Enhanced (September 2026)

**Target:** Fitur core lengkap untuk operasional harian

**New Features:**
- Absensi/Attendance System
- Rapor Generation
- Pengumuman & Notifications
- Excel Import/Export
- Email Notifications

**Improvements:**
- Performance optimization
- Mobile responsive improvements
- Bug fixes dari Release 1.0
- Enhanced reporting

**Release Date:** 30 September 2026

---

### Release 1.2 - Advanced (December 2026)

**Target:** Fitur advanced untuk analitik dan integrasi

**New Features:**
- Advanced Analytics Dashboard
- Custom Reports
- PWA Support
- REST API
- DAPODIK Integration

**Improvements:**
- Security hardening
- Performance optimization
- Complete documentation
- Video tutorials

**Release Date:** 31 Desember 2026

---

### Release 2.0 - Platform (March 2027)

**Target:** Platform lengkap dengan mobile app dan multi-tenant

**New Features:**
- Native Mobile App (iOS/Android)
- Multi-tenant Support
- Enhanced API v2
- AI-powered Recommendations
- Advanced Analytics

**Release Date:** 31 Maret 2027

---

## 🎯 Sprint Goals

### ✅ Sprint 1 (1-2 weeks) - DONE
**Goal:** Setup authentication dan RBAC system  
**Delivered:**
- Laravel Breeze authentication
- Custom RBAC (5 roles, 16 permissions)
- Role/Permission middleware
- Super admin user seeder

---

### ✅ Sprint 2 (2 weeks) - DONE
**Goal:** User management dan data akademik master  
**Delivered:**
- User CRUD dengan role assignment
- Tahun Ajaran CRUD
- Jurusan CRUD
- Kelas CRUD
- Mata Pelajaran CRUD

---

### ✅ Sprint 3 (2 weeks) - DONE
**Goal:** Guru & Siswa management  
**Delivered:**
- Guru management + mata pelajaran assignment
- Siswa CRUD dengan data lengkap
- Integration dengan users table
- Photo upload untuk siswa

---

### ✅ Sprint 4 (2 weeks) - DONE
**Goal:** Dashboard untuk semua roles  
**Delivered:**
- Super Admin Dashboard
- Admin Dashboard
- Akademik Dashboard
- Guru Dashboard
- Siswa Dashboard

---

### ✅ Sprint 5 (2 weeks) - DONE
**Goal:** Time slots dan guru-mapel-kelas assignment  
**Delivered:**
- Time Slots management
- Seeder untuk default time slots
- Guru-Mapel-Kelas CRUD
- Auto-generate assignment
- Bulk operations

---

### ✅ Sprint 6 (2 weeks) - DONE
**Goal:** Advanced scheduling system  
**Delivered:**
- Schedule generation algorithm
- Manual schedule editing
- Swap & move schedules
- Weekly grid view
- Conflict validation

---

### 📋 Sprint 7 (2 weeks) - NEXT
**Goal:** Nilai CRUD dan input by guru  
**Planned:**
- Database schema untuk nilai
- Nilai CRUD operations
- Guru input interface
- Batch input nilai
- Validation & filters

**Start Date:** TBD  
**End Date:** TBD

---

### 📋 Sprint 8 (2 weeks)
**Goal:** Rapor calculation dan generation  
**Planned:**
- Rapor calculation service
- Formula implementation
- Rapor view & print
- PDF export
- Testing

---

### 📋 Sprint 9 (2 weeks)
**Goal:** Absensi CRUD dan batch input  
**Planned:**
- Database schema absensi
- Absensi CRUD
- Batch input interface
- Validation
- Filter & search

---

### 📋 Sprint 10 (2 weeks)
**Goal:** Rekap absensi dan notifications  
**Planned:**
- Rekap calculation
- Email notifications
- Siswa absensi view
- Excel export
- WhatsApp integration (optional)

---

## 📊 Velocity Tracking

### Historical Velocity

| Sprint | Planned Points | Completed Points | Velocity | Notes |
|--------|----------------|------------------|----------|-------|
| Sprint 1 | 21 | 21 | 21 | Auth & RBAC |
| Sprint 2 | 18 | 18 | 21 | User + Data Akademik |
| Sprint 3 | 21 | 21 | 20 | Guru & Siswa |
| Sprint 4 | 21 | 21 | 20.75 | Dashboards |
| Sprint 5 | 13 | 13 | 19 | Time Slots + Assignment |
| Sprint 6 | 21 | 21 | 19.17 | Scheduling |

**Average Velocity:** ~20 points/sprint  
**Team Capacity:** 2-3 developers  
**Sprint Duration:** 2 weeks

### Forecast

Dengan velocity rata-rata 20 points/sprint:
- **Phase 2** (89 points) = ~4.5 sprints = 9 weeks = Jun-Jul 2026 ✅
- **Phase 3** (76 points) = ~3.8 sprints = 8 weeks = Ago-Sep 2026 ✅

---

## 🎯 OKRs (Objectives & Key Results)

### Q2 2026 (Apr-Jun)

**Objective:** Meluncurkan MVP sistem akademik yang functional

**Key Results:**
- ✅ KR1: Complete Phase 1 (144 story points) - 100% DONE
- 🚧 KR2: Complete 50% of Phase 2 - 0% (Target: Jun 30)
- 📋 KR3: Achieve 70% automated test coverage - 0%
- 📋 KR4: Onboard 1 pilot school - 0%
- 📋 KR5: User satisfaction > 4/5 - TBD

---

### Q3 2026 (Jul-Sep)

**Objective:** Enhance sistem dengan fitur core lengkap

**Key Results:**
- 📋 KR1: Complete Phase 2 (100%)
- 📋 KR2: Launch Release 1.1
- 📋 KR3: Onboard 3 more schools
- 📋 KR4: 0 critical bugs in production
- 📋 KR5: User training completion rate > 90%

---

### Q4 2026 (Oct-Dec)

**Objective:** Provide advanced features dan integrasi

**Key Results:**
- 📋 KR1: Complete Phase 3 (100%)
- 📋 KR2: Launch Release 1.2 dengan PWA
- 📋 KR3: API used by 2+ integrations
- 📋 KR4: Mobile usage > 40%
- 📋 KR5: System uptime > 99.5%

---

## 📋 Feature Requests Backlog

### User-Requested Features

| ID | Feature Request | Requested By | Priority | Votes | Status | Notes |
|----|----------------|--------------|----------|-------|--------|-------|
| FR-001 | Export jadwal to Google Calendar | Guru | 🟡 MEDIUM | 15 | 📋 BACKLOG | API integration needed |
| FR-002 | WhatsApp notification untuk orang tua | Akademik | 🟠 HIGH | 23 | 📋 PLANNED | Sprint 10 |
| FR-003 | Bulk upload siswa via Excel | Admin | 🟠 HIGH | 18 | 📋 PLANNED | Sprint 8 |
| FR-004 | E-Rapor sesuai format Kemendikbud | Akademik | 🟡 MEDIUM | 12 | 📋 BACKLOG | Research needed |
| FR-005 | Dark mode | Siswa | 🟢 LOW | 8 | 📋 BACKLOG | UI enhancement |
| FR-006 | Print kartu siswa dengan barcode | Admin | 🟡 MEDIUM | 10 | 📋 BACKLOG | Requires barcode library |
| FR-007 | Chat/messaging antar user | Guru | 🟢 LOW | 6 | 📋 FUTURE | Large feature |
| FR-008 | Jadwal ujian terpisah | Akademik | 🟠 HIGH | 14 | 📋 PLANNED | Sprint 9 |
| FR-009 | Presensi via QR Code | Guru | 🟡 MEDIUM | 11 | 📋 BACKLOG | Requires mobile app |
| FR-010 | Dashboard untuk orang tua | Siswa | 🟡 MEDIUM | 13 | 📋 FUTURE | New role needed |

---

## 🐛 Known Issues & Tech Debt

### Critical Issues
- Tidak ada (per Apr 22, 2026)

### High Priority
- Tidak ada (per Apr 22, 2026)

### Medium Priority
- 🐛 BUG-001: Schedule generation timeout untuk sekolah besar (>50 kelas) - Optimasi needed
- 🔧 DEBT-001: Refactor ScheduleController (too large) - Split into service

### Low Priority
- 🐛 BUG-002: Responsive issue di table jadwal pada mobile kecil - UI fix needed
- 🔧 DEBT-002: Missing unit tests untuk beberapa controllers - Add tests

### Tech Debt Items

| ID | Description | Impact | Effort | Priority | Plan |
|----|-------------|--------|--------|----------|------|
| TD-001 | Refactor ScheduleController | 🟡 MEDIUM | 4h | 🟡 MEDIUM | Sprint 7 |
| TD-002 | Add missing unit tests | 🟠 HIGH | 8h | 🟠 HIGH | Sprint 7-8 |
| TD-003 | Database indexes optimization | 🟡 MEDIUM | 2h | 🟡 MEDIUM | Sprint 8 |
| TD-004 | Implement caching layer | 🟠 HIGH | 6h | 🟠 HIGH | Sprint 9 |
| TD-005 | Code documentation (PHPDoc) | 🟢 LOW | 10h | 🟢 LOW | Ongoing |

---

## 🎨 UX/UI Improvements Backlog

| ID | Improvement | Priority | Effort | Status | Notes |
|----|-------------|----------|--------|--------|-------|
| UI-001 | Add loading skeletons | 🟡 MEDIUM | 4h | 📋 TODO | Better UX |
| UI-002 | Improve form validation feedback | 🟠 HIGH | 3h | 📋 TODO | User requested |
| UI-003 | Add keyboard shortcuts | 🟢 LOW | 6h | 📋 BACKLOG | Power users |
| UI-004 | Improve mobile navigation | 🟠 HIGH | 5h | 📋 PLANNED | Sprint 14 |
| UI-005 | Add tutorial tooltips | 🟡 MEDIUM | 8h | 📋 BACKLOG | Onboarding |
| UI-006 | Dark mode theme | 🟢 LOW | 12h | 📋 BACKLOG | User requested |
| UI-007 | Customizable dashboard widgets | 🟡 MEDIUM | 10h | 📋 FUTURE | Advanced feature |

---

## 📚 Documentation Status

| Document | Status | Last Updated | Owner | Next Review |
|----------|--------|--------------|-------|-------------|
| README.md | ✅ COMPLETE | Apr 22, 2026 | Dev Team | Jun 2026 |
| PRODUCT_REQUIREMENT_DOCUMENT.md | ✅ COMPLETE | Apr 22, 2026 | PM | Jun 2026 |
| DEVELOPMENT_TICKETS.md | ✅ COMPLETE | Apr 22, 2026 | PM | Weekly |
| FEATURE_DEVELOPMENT_GUIDE.md | ✅ COMPLETE | Apr 22, 2026 | Lead Dev | Monthly |
| RBAC_DOCUMENTATION.md | ✅ COMPLETE | Apr 21, 2026 | Dev Team | Jun 2026 |
| SCHEDULING_SYSTEM_IMPLEMENTATION.md | ✅ COMPLETE | Apr 21, 2026 | Dev Team | Jun 2026 |
| API_DOCUMENTATION.md | 📋 TODO | - | Dev Team | Sprint 15 |
| USER_MANUAL.md | 📋 TODO | - | Tech Writer | Jun 2026 |
| DEPLOYMENT_GUIDE.md | 🚧 DRAFT | Apr 22, 2026 | DevOps | May 2026 |

---

## 🎯 Definition of Ready (DoR)

Sebuah user story dianggap READY untuk dikerjakan jika:

- ✅ User story clearly defined dengan acceptance criteria
- ✅ Story points estimated oleh team
- ✅ Dependencies identified dan resolved
- ✅ Design mockups tersedia (untuk UI changes)
- ✅ Technical approach agreed upon
- ✅ Test scenarios defined
- ✅ Assigned to a developer

---

## 🎯 Definition of Done (DoD)

Sebuah user story dianggap DONE jika:

- ✅ Code implemented sesuai acceptance criteria
- ✅ Unit tests written dan passing
- ✅ Integration tests written dan passing
- ✅ Feature tested manually
- ✅ Code reviewed dan approved (min 1 reviewer)
- ✅ No critical bugs
- ✅ Documentation updated
- ✅ Merged to main branch
- ✅ Deployed to staging
- ✅ Demo to Product Owner (PO approval)

---

## 👥 Team Roles & Responsibilities

### Product Owner (PO)
- **Responsibilities:**
  - Maintain product backlog
  - Prioritize features
  - Accept/reject completed work
  - Stakeholder communication
  
### Scrum Master (SM)
- **Responsibilities:**
  - Facilitate ceremonies
  - Remove blockers
  - Coach team on agile practices
  - Track velocity

### Development Team
- **Backend Developer(s):**
  - Database design
  - Controllers & services
  - API development
  - Unit testing
  
- **Frontend Developer(s):**
  - UI/UX implementation
  - Blade templates
  - JavaScript/Alpine.js
  - Responsive design
  
- **Full Stack Developer(s):**
  - End-to-end features
  - Integration work
  - Bug fixes
  
- **QA Engineer:**
  - Test planning
  - Manual testing
  - Bug reporting
  - Test automation
  
- **DevOps Engineer:**
  - Deployment
  - CI/CD pipeline
  - Monitoring
  - Server management

---

## 📅 Scrum Ceremonies

### Sprint Planning
- **When:** First day of sprint
- **Duration:** 2-4 hours
- **Attendees:** Full team
- **Purpose:** Plan sprint backlog, estimate stories

### Daily Standup
- **When:** Every day, 9:00 AM
- **Duration:** 15 minutes
- **Format:** 
  - What did I do yesterday?
  - What will I do today?
  - Any blockers?

### Sprint Review
- **When:** Last day of sprint
- **Duration:** 1-2 hours
- **Attendees:** Full team + stakeholders
- **Purpose:** Demo completed work, get feedback

### Sprint Retrospective
- **When:** After sprint review
- **Duration:** 1 hour
- **Attendees:** Development team
- **Purpose:** 
  - What went well?
  - What didn't go well?
  - Action items for improvement

### Backlog Refinement
- **When:** Mid-sprint
- **Duration:** 1-2 hours
- **Attendees:** PO + team
- **Purpose:** Groom upcoming stories, estimate, clarify

---

## 📊 Metrics & KPIs

### Development Metrics

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Velocity | 20 points/sprint | 19.17 | ✅ ON TRACK |
| Sprint Commitment | 100% | 100% | ✅ EXCELLENT |
| Code Coverage | >70% | ~30% | 🔴 NEEDS WORK |
| Code Review Time | <24h | ~12h | ✅ GOOD |
| Bug Density | <5 bugs/sprint | 0 | ✅ EXCELLENT |
| Technical Debt Ratio | <20% | ~15% | ✅ GOOD |

### Product Metrics

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Active Schools | 5 by Q3 | 0 (pre-launch) | 📋 PENDING |
| Daily Active Users | 100 by Q3 | 0 (pre-launch) | 📋 PENDING |
| User Satisfaction | >4.0/5 | TBD | 📋 PENDING |
| Feature Adoption | >60% | TBD | 📋 PENDING |
| System Uptime | >99% | TBD | 📋 PENDING |

---

## 🚀 Go-to-Market Strategy

### Phase 1: Pilot Program (Jun-Jul 2026)
- Target: 1 pilot school
- Free trial for 3 months
- Intensive training & support
- Gather feedback
- Fix critical issues

### Phase 2: Early Adopters (Ago-Sep 2026)
- Target: 3-5 schools
- Discounted pricing
- Onboarding support
- Case study creation
- Testimonials

### Phase 3: General Availability (Okt 2026+)
- Open to all schools
- Standard pricing
- Self-service onboarding
- Marketing campaign
- Referral program

---

## 💰 Pricing Strategy (Draft)

### Freemium Model
- **Free Tier:**
  - Up to 100 siswa
  - Basic features (scheduling, attendance)
  - Community support
  
### Professional Tier
- **Price:** Rp 500.000/bulan atau Rp 5.000.000/tahun
- **Features:**
  - Unlimited siswa
  - All features
  - Email support
  - Training included
  
### Enterprise Tier
- **Price:** Custom
- **Features:**
  - Multi-campus support
  - API access
  - Dedicated support
  - Custom integrations
  - On-premise option

---

## 📞 Support & Maintenance Plan

### Support Channels
- Email: support@sistemakademik.id
- WhatsApp: +62-xxx-xxx-xxxx
- Knowledge Base: docs.sistemakademik.id
- Video Tutorials: YouTube channel

### Support SLA
- **Critical Issues:** Response <2h, Resolution <24h
- **High Issues:** Response <4h, Resolution <48h
- **Medium Issues:** Response <24h, Resolution <1 week
- **Low Issues:** Response <48h, Resolution <2 weeks

### Maintenance Windows
- **Scheduled Maintenance:** Sunday 02:00-04:00 WIB
- **Emergency Maintenance:** As needed, with notification

---

## 📝 Change Log

### Version 1.0 (Current)
- Initial product backlog
- Roadmap Q2-Q4 2026
- OKRs defined
- Team structure
- Pricing strategy

### Upcoming Changes
- TBD based on sprint reviews

---

## 🔄 Review & Update Schedule

- **Product Backlog:** Reviewed weekly in backlog refinement
- **Roadmap:** Reviewed monthly
- **OKRs:** Reviewed quarterly
- **Metrics:** Reviewed weekly in sprint planning
- **This Document:** Updated weekly or as needed

---

**Document Owner:** Product Manager  
**Last Updated:** 22 April 2026  
**Next Review:** 29 April 2026  
**Status:** Active


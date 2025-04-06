<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            "Engineering Mathematics I", "Engineering Mathematics II", "Engineering Physics", "Engineering Chemistry",
            "Engineering Mechanics", "Computer Programming", "Data Structures", "Algorithms", "Digital Electronics",
            "Microprocessors & Microcontrollers", "Computer Networks", "Operating Systems", "Database Management Systems",
            "Software Engineering", "Artificial Intelligence", "Machine Learning", "Cloud Computing", "Cyber Security",
            "Internet of Things", "Web Development", "Mobile Application Development", "Embedded Systems", "Computer Graphics",
            "Big Data Analytics", "Distributed Systems", "Cryptography & Network Security", "Blockchain Technology",
            "Digital Signal Processing", "Compiler Design", "Object-Oriented Programming", "System Programming",
            "Theory of Computation", "Image Processing", "Natural Language Processing", "Human-Computer Interaction",
            "Automata Theory", "Wireless Communication", "Bioinformatics", "Neural Networks", "Quantum Computing",
            "Ethical Hacking", "Software Testing", "Parallel Computing", "VLSI Design", "Virtual Reality", "Augmented Reality",
            "Game Development", "Embedded C Programming", "Artificial Neural Networks", "Cloud Security", "Mobile Computing",
            "Digital Forensics", "Robotics", "Smart Grid Technology", "Biomedical Engineering", "Mechatronics",
            "Electromagnetic Theory", "Instrumentation & Measurement", "Signal & Systems", "Energy Systems", "Power Electronics",
            "Control Systems", "Analog Electronics", "Thermodynamics", "Fluid Mechanics", "Heat Transfer",
            "Engineering Economics", "Materials Science", "Automobile Engineering", "Hydraulics & Pneumatics",
            "Mechanical Vibrations", "Production Planning & Control", "Renewable Energy", "Structural Engineering",
            "Environmental Engineering", "Transportation Engineering", "Geotechnical Engineering", "Surveying & Mapping",
            "Construction Management", "Water Resource Engineering", "Aerospace Engineering", "Naval Architecture",
            "Marine Engineering", "Petroleum Engineering", "Mining Engineering", "Textile Engineering",
            "Food Processing Technology", "Biotechnology", "Nanotechnology", "Pharmaceutical Technology",
            "Chemical Engineering", "Polymer Technology", "Metallurgical Engineering", "Nuclear Engineering",
            "Artificial Intelligence Ethics", "Soft Computing", "Evolutionary Algorithms", "Fuzzy Logic",
            "Deep Learning", "Cognitive Computing", "IoT Security"
        ];

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert([
                'id' => Str::uuid(),
                'name' => $subject,
                'code' => strtoupper(Str::random(6)), // Generates a unique subject code
                'credits' => rand(2, 4),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

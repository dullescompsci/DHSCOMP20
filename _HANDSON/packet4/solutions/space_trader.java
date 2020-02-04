import java.util.*;
import java.awt.*;
import java.io.*;
import java.text.DecimalFormat;

public class space_trader
{
    static int[][] connections = new int[26][26];

    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("space_trader.dat"));

        String startingPlanet = fromFile.nextLine();
        ArrayList<Character> visitLocations = new ArrayList<>();
        visitLocations.add('A');

        for(int r=0; r<connections.length; r++)
            for(int c=0; c<connections[0].length; c++)
                connections[r][c]=-1;

        while(fromFile.hasNextLine())
        {
            String[] temp = fromFile.nextLine().split("/");
            char planetA = temp[0].charAt(0);
            char planetB = temp[1].charAt(0);
            int distance = Integer.parseInt(temp[1].substring(4));

            connections[planetA-'A'][planetB-'A'] = distance;
            connections[planetB-'A'][planetA-'A'] = distance;
        }


        System.out.println(mostPlanets(startingPlanet));
    }

    public static int mostPlanets(String start)
    {
        Set<String> uniquePaths = new HashSet<>();
        ArrayList<String> pathsToCheck = new ArrayList<>();

        String temp =  ""+start;

        pathsToCheck.add(temp);
        while(pathsToCheck.size()>0)
        {

            String current= pathsToCheck.remove(0);
            //System.out.println(current +" * "+ pathDistance(current));
            if(pathDistance(current) > 50)
                uniquePaths.add(current.substring(0,current.length()-1));
            else
            {
                char at = current.charAt(current.length()-1);
                boolean gotLonger=false;
                for(char letter='A'; letter<='Z'; letter++)
                    if(connections[at-'A'][letter-'A']!=-1 && !current.contains(letter+""))
                    {
                        gotLonger=true;
                        String clone = current+letter;
                        pathsToCheck.add(clone);
                    }
                if(!gotLonger)
                    uniquePaths.add(current);
            }
        }

        int maxPlanets=-1;
        for(String s: uniquePaths) {
            if (maxPlanets < planetCount(s)) {
                //System.out.println(s + pathDistance(s));
                maxPlanets = planetCount(s);
            }
        }

        return maxPlanets;
    }

    public static int pathDistance(String path)
    {
        int distance = 0;
        for(int x=0; x<path.length()-1;x++)
            distance+=connections[path.charAt(x)-'A'][path.charAt(x+1)-'A'];
        return distance;
    }

    public static int planetCount(String path)
    {
        int count = -1;
        for(char letter='A'; letter<='Z'; letter++)
            if(path.contains(letter+""))
                count++;
        return count;
    }
}